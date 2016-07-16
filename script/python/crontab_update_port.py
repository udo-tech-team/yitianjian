#!/usr/bin/python
# -*- coding: utf-8 -*-

######################################
#
# @param:  trial_port_crontab | expired_crontab | merchant_crontab | accident_recover
#    crontab to update port status
#
######################################

import socket
import hashlib
import logging
import os
import sys
import time
import traceback
import ConfigParser

cur_dir = os.getcwd()
sys.path.append(cur_dir + '/selfmod/')
import Database

class UpdatePort:
    # the limit of update ports 
    max_update_port = 10000
    dbObj = None
    time_format = '%Y-%m-%d %X'
    sock = None
    conf_file = './conf/crontab_update_port.conf'
    conf = None
    # global mark to decide go on or not
    GOON = True

    # crond type
    TRIAL_PORT_CRONTAB = 'trial_port_crontab'
    EXPIRED_CRONTAB = 'expired_crontab'
    MERCHANT_CRONTAB = 'merchant_crontab'
    ACCIDENT_RECOVER = 'accident_recover'
    # trial_port status
    trial_status = 3
    # trial_port deleted status
    trial_deleted_status = 2
    # merchant_port status
    merchant_status = 4
    # in use status
    port_in_use_status = 1
    # invalid status
    port_invalid_status = 8
    # available status
    port_available_status = 0
    # add the port after expired for k days
    k_days_ago = 30

    BATCH_INSERT_PORT_NUM = 100

    def __init__(self):
      logging.basicConfig(level=logging.DEBUG,
            format='%(asctime)s %(filename)s[%(lineno)s] %(levelname)s %(message)s',
            datefmt='%d %b %Y %H:%M:%S',
            filename='./logs/crond_update_port.log',
            filemode='a')

    def load_conf(self):
      if not self.GOON:
          logging.warning('GOON is false, stop.')
          return
      try:
        cf = ConfigParser.ConfigParser()
        cf.read(self.conf_file)
        clt_sec = 'socket_client'
        self.conf = {}
        self.conf['remote_port'] = cf.get(clt_sec, 'remote_port')
        self.conf['remote_ip'] = cf.get(clt_sec, 'remote_ip')
        self.conf['pass_cmd_seperator'] = cf.get(clt_sec, 'pass_cmd_seperator')
        self.conf['password'] = cf.get(clt_sec, 'password')
        self.conf['debug_mode'] = cf.get(clt_sec, 'debug_mode')
        #self.conf[''] = cf.get(clt_sec, '')
        log_str = 'load_conf succ, %s' % (self.conf)
        logging.debug(log_str)
      except Exception as e:
        self.GOON = False
        log_str = 'exception occurs[%s]' % (e)
        logging.warning(log_str)

    def init_sock(self, remote_ip):
      if not self.GOON:
          logging.warning('GOON is false, stop.')
          return
      try:
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.sock.connect((remote_ip, (int)(self.conf['remote_port'])))
        log_str = 'init_sock succ, %s' % (self.sock)
        logging.debug(log_str)
      except Exception as e:
        self.GOON = False
        log_str = 'exception occurs[%s]' % (e)
        logging.warning(log_str)

    def insert_port(self, port, password):
        """ insert an account in ssserver, port/password as param"""
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return False
        # insert an account, with port / password
        # 1. remove port 2. add the removed port 
        cmd = 'remove:{"server_port":' + str(port) + '}'
        net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + cmd
        self.sock.sendall(net_str)
        exec_res = self.sock.recv(1024)

        log_str = '[%s] exec res[%s]' % (net_str, exec_res)
        if exec_res != 'ok':
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        cmd = 'add:{"server_port":' + str(port) + ',"password":"' + password + '"}'
        net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + cmd
        self.sock.sendall(net_str)
        exec_res = self.sock.recv(1024)

        log_str = '[%s] exec res[%s]' % (net_str, exec_res)
        if exec_res != 'ok':
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        return True

    def get_transformed_portpass(self, table_rec_list):
        """ transform db records to [port@pass, port@pass] string list
            @in: port records list
            @return string list
        """
        pass

    def insert_multi_port(self, port_pass_arr):
        """ insert multi accounts in ssserver, port/password arr as param"""
        # @in: [port@pass,port@pass,...], string list
        # @return: True on success, otherwise False

        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return False
        # 1. pack the ports/passwords,
        # 2. send the package to remote ssserver
        # 3. get result
        # pack format: port@pass,port@pass......
        if not isinstance(port_pass_arr, list):
            self.GOON = False
            logging.warning('input param err, stop.')
            return False
        pack_str = ','.join(port_pass_arr)
        net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + pack_str
        self.sock.sendall(net_str)
        exec_res = self.sock.recv(1024)

        log_str = '[%s] exec res[%s]' % (net_str, exec_res)
        if exec_res != 'ok':
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        return True

    def remove_port(self, port):
        """ single function to remove port on ssserver without other operations"""
        if not port or not self.GOON:
            log_str = 'GOON is false or port[%s], stop.' % (port)
            logging.warning(log_str)
            return False

        # remove port
        cmd = 'remove:{"server_port":' + str(port) + '}'
        net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + cmd
        self.sock.sendall(net_str)
        exec_res = self.sock.recv(1024)

        log_str = '[%s] exec res[%s]' % (net_str, exec_res)
        if exec_res != 'ok':
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        return True


    def update_port(self, rec):
        """ this function is decreapted as the opeartion of changing a port password
            all at a sudden may cause the user's ip in iptables drop list
        """
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return False
        #change ss_pass
        # 1. remove port 2. add the removed port with another pass
        # 3. update in db table
        cmd = 'remove:{"server_port":' + str(rec[1]) + '}'
        net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + cmd
        self.sock.sendall(net_str)
        exec_res = self.sock.recv(1024)

        log_str = '[%s] exec res[%s]' % (net_str, exec_res)
        if exec_res != 'ok':
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        # add the removed port with another pass
        old_pass = rec[4]
        new_pass = self.get_next_sspass(old_pass)
        cmd = 'add:{"server_port":' + str(rec[1]) + ',"password":"' + new_pass + '"}'
        net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + cmd
        self.sock.sendall(net_str)
        exec_res = self.sock.recv(1024)

        log_str = '[%s] exec res[%s]' % (net_str, exec_res)
        if exec_res != 'ok':
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        # update cake_ports
        # update_query = 'update cake_ports set sspass="' + new_pass + '" where id = ' + str(rec[0])
        update_query = 'update cake_ports set sspass="%s", modified=now() where id=%s' % (new_pass, rec[0])
        exec_res = self.dbObj.exec_query(update_query)
        log_str = '[%s] exec res[%s]' % (update_query, exec_res)
        if exec_res < 1:
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        return True

    def reset_expired_port(self):
      """reset expired port[update status/uid/expire/sspass fields]"""
      # first update status/uid, so record will not show in ucenter.
      #     mark status as invalid, remove the port from ssserver, 
      #     so if the user still use the port, user's ip will not in iptables drop list
      # second change sspass, so the account is invalid for formmer user
      if not self.GOON:
          logging.warning('GOON is false, stop.')
          return
      try:

        # first step, set expired ports invalid and delete on ssserver
        self.dbObj = Database.MysqlObj()
        # select records and log
        time_now = time.strftime(self.time_format, time.localtime(time.time()))
        sql_query = 'select * from cake_ports where expire <= "' + time_now  \
                + '" and status = ' + str(self.port_in_use_status)
        if self.conf['debug_mode'] != '0':
            sql_query = sql_query  + ' limit 1 '
        count, all_res = self.dbObj.find_all(sql_query)
        log_str = 'query[%s] record count[%s]' % (sql_query, count)
        logging.info(log_str)

        for rec in all_res:
            #rec(is, ssport,sshost,ssencrypt,sspass,status,created,modified,uid,sip,expire)
            #print rec[0], rec[4]
            log_str = '%s get rec[%s]' % ('cake_ports', rec)
            logging.info(log_str)

            # update cake_ports
            update_query = 'update cake_ports set status = %d, uid = 0, mtid=0, modified=now() where id = %d' \
                    % (self.port_invalid_status, rec[0])
            #exec_res = 1
            exec_res = self.dbObj.exec_query(update_query)
            log_str = '[%s] exec res[%s]' % (update_query, exec_res)
            if exec_res < 1:
                logging.critical(log_str)
                continue
            else:
                logging.info(log_str)
                # remove the expired port on ssserver
                remove_res = self.remove_port(rec[1])
                log_str = 'remove port[%d] res[%s]' % (rec[1], remove_res)
                logging.warning(log_str)

        # second step, add long time(k days ago) invalid ports
        last_k_days_to_seconds = self.k_days_ago * 60 * 60 * 24 
        time_ago = time.strftime(self.time_format, time.localtime(time.time() - last_k_days_to_seconds))
        sql_query = 'select * from cake_ports where expire <= "' + time_ago \
                + '" and status = ' + str(self.port_invalid_status)
        if self.conf['debug_mode'] != '0':
            sql_query = sql_query  + ' limit 1 '
        count, all_res = self.dbObj.find_all(sql_query)
        log_str = 'query[%s] record count[%s]' % (sql_query, count)
        logging.info(log_str)
        for rec in all_res:
            if not self.update_port(rec):
                log_str = 'port_id[%d] update failed.' % (rec[0])
                logging.critical(log_str)
            else:
                # update cake_ports set to available
                update_query = 'update cake_ports set status = %d, modified=now() where id = %d' \
                        % (self.port_available_status, rec[0])
                #exec_res = 1
                exec_res = self.dbObj.exec_query(update_query)
                log_str = 'cmd[%s] port_id[%d] update is_succ[%d]' % (update_query, rec[0], exec_res)
                logging.info(log_str)


      except Exception as e:
        self.GOON = False
        log_str = 'exception occurs[%s]' % (e)
        logging.warning(log_str)
      # finally close socket. important !!!!
      # client not close, server will in dead loop
      self.sock.close()

    # just for test connectivity betwee c/s
    def send_cmd_to_manager_server(self, cmd):
        if not self.GOON:
          logging.warning('GOON is false, stop.')
          return
        cmd = 'some text' + str(time.time())
        i = 10
        while i > 0:
            self.sock.sendall(cmd)
            print i, cmd
            i = i -1
            print self.sock.recv(1024)
        self.sock.close()

    def get_next_sspass(self, old_pass):
        if not self.GOON:
          logging.warning('GOON is false, stop.')
          return
        if old_pass is None:
            old_pass = (str)(time.time())
            wrn_log = 'old_pass null, generate one[%s]' % (old_pass)
            logging.warning(wrn_log)
        new_pass = hashlib.md5(old_pass).hexdigest()
        new_pass_6bit = new_pass[0:6]
        log_str = 'old_pass[%s] new_pass[%s] 6bit[%s]' %  \
                (old_pass, new_pass, new_pass_6bit)
        logging.debug(log_str)

        return new_pass_6bit

    def update_trial_port(self):
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return
        try:
            self.dbObj = Database.MysqlObj()
            sql_query = 'select * from cake_ports where status=%d order by id desc limit 1' % (self.trial_status) 
            count, all_res = self.dbObj.find_all(sql_query)
            log_str = 'query[%s] record count[%d]' % (sql_query, count)
            # early version only 1 trail_port
            if count == 1:
                # trial_port exists
                logging.info(log_str)
                rec = all_res[0]
                if not self.update_port(rec):
                    log_str = 'port_id[%d] update failed.' % (rec[0])
                    logging.critical(log_str)
                else:
                    log_str = 'port_id[%d] update succ' % (rec[0])
            else:
                logging.critical(log_str)
                # trial_port not exists
                # try allocate a trial port
                while True:
                    sql_query = 'select * from cake_ports where status=0 and uid=0 order by id desc limit 1'
                    count, all_res = self.dbObj.find_all(sql_query)
                    log_str = 'query[%s] record count[%s]' % (sql_query, count)
                    # no available port
                    if count < 1:
                        logging.critical(log_str)
                        break
                    logging.info(log_str)
                    update_query = 'update cake_ports set status=3, modified=now() where id=%s' % (all_res[0][0])
                    exec_res = self.dbObj.exec_query(update_query)
                    log_str = 'query[%s] exec_res[%s] id[%d]' % (sql_query, exec_res, all_res[0][0])
                    if exec_res != 1:
                        logging.critical(log_str)
                        break
                    else:
                        logging.info(log_str)
                    # this is a fake while loop to avoid too many levels of if/else statement
                    break
        except Exception as e:
            log_str = 'exception occurs, [%s]' % (e)
            logging.warning(log_str)
        self.sock.close()

    def assign_merchant_port(self, mtid):
        if not mtid:
            log_str = 'empty mtid'
            logging.warning(log_str)
            return False
        sql_query = 'select * from cake_ports where status=%d and mtid=%d order by id DESC limit 1' \
                % (self.merchant_status, mtid)
        count, all_res = self.dbObj.find_all(sql_query)
        # this is a fake while loop
        while True:
            if count > 0:
                log_str = 'mtid[%s] already has ssport' % (mtid)
                logging.warning(log_str)
                break
            # find an available port
            sql_query = 'select id from cake_ports where status=0 and uid=0 and mtid=0 order by id DESC limit 1'
            count, all_res = self.dbObj.find_all(sql_query)
            log_str = 'query[%s] record count[%s]' % (sql_query, count)
            if count < 1:
                logging.critical(log_str)
                break
            # available port exists
            port_id = all_res[0][0]
            
            # assign port to merchant
            update_query = 'update cake_ports set status=%d, mtid=%d, modified=now() where id=%d' \
                    % (self.merchant_status, mtid, port_id)
            exec_res = self.dbObj.exec_query(update_query)
            log_str = 'query[%s] exec_res[%s]' % (update_query, exec_res)
            if not exec_res:
                logging.critical(log_str)
            else:
                logging.info(log_str)

            # finally exit while
            break

        return True

    def update_merchant_port(self):
        # many merchants, many ports
        # update ports by mtid
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return
        try:
            self.dbObj = Database.MysqlObj()
            sql_query = 'select id from cake_merchants'
            count, all_res = self.dbObj.find_all(sql_query)
            log_str = 'query[%s] record count[%d]' % (sql_query, count)
            if count >= 1:
                # merchant exists
                logging.info(log_str)
                # traverse all record
                # rec(id,created,modified,is_verified,level,orders_score,...)
                for rec in all_res:
                    # get merchant port record
                    sql_query = 'select * from cake_ports where status=%d and mtid=%d order by id DESC limit 1' \
                            % (self.merchant_status, rec[0])
                    count, all_res = self.dbObj.find_all(sql_query)
                    if count > 0:
                        # merchant port record exists
                        up_res = self.update_port(all_res[0])
                        log_str = 'mtid[%s] port record[%s] update res[%s]' % (rec[0], all_res[0], up_res)
                        if not up_res:
                            logging.critical(log_str)
                        else:
                            logging.info(log_str)
                    else:
                        # merchant port record not exists
                        mtid = rec[0]
                        if not self.assign_merchant_port(mtid):
                            log_str = 'assign mercahnt port failed.mtid[%s]' % (rec[0])
                            logging.critical(log_str)
            else:
                #no merchants
                logging.warning(log_str)
        except Exception as e:
            log_str = 'exception occurs, [%s] sys[%s] traceback[%s]' \
                    % (e, sys.exc_info(), traceback.print_exc())
            logging.warning(log_str)

    def accident_recover(self):
        # this is not a crontab
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return
        exec_succ = False
        try:
            self.dbObj = Database.MysqlObj()
            sql_query = 'select ssport, sspass from cake_ports where status not in (%d, %d) '\
                    % (self.trial_deleted_status, self.port_invalid_status)
            count, all_res = self.dbObj.find_all(sql_query)
            log_str = 'query[%s] record count[%d]' % (sql_query, count)
            if count >= 1:
                # ports exists
                logging.info(log_str)

                total_count = 0
                succ_count = 0
                cur_count = 0
                port_pass_arr = []
                for rec in all_res:
                    port_pass_str = '%d@%s' % (rec[0], rec[1])
                    port_pass_arr.append(port_pass_str)
                    cur_count += 1
                    total_count += 1
                    if cur_count >= self.BATCH_INSERT_PORT_NUM:
                        batch_res = self.insert_multi_port(port_pass_arr)
                        log_str = 'insert count[%d] res[%s]' % (cur_count, batch_res)
                        logging.warning(log_str)
                        if batch_res:
                            succ_count += cur_count

                        #reset
                        cur_count = 0
                        port_pass_arr = []

                if len(port_pass_arr) > 0:
                        batch_res = self.insert_multi_port(port_pass_arr)
                        log_str = 'last time. insert count[%d] res[%s]' \
                                % (cur_count, batch_res)
                        logging.warning(log_str)
                        if batch_res:
                            succ_count += cur_count
                logging.info("finished insert. total[%s] succ[%s]" \
                        % (total_count, succ_count))

            else:
                #no ports
                logging.warning(log_str)
            # arrive here means all executed, marked as succ
            exec_succ = True
        except Exception as e:
            log_str = 'exception occurs, [%s] sys[%s] traceback[%s]' \
                    % (e, sys.exc_info(), traceback.print_exc())
            logging.warning(log_str)
        return exec_succ

    def client_start(self, remote_ip = None):
        self.load_conf()
        # if param remote_ip None, use conf value
        self.init_sock(remote_ip or self.conf['remote_ip'])
        if len(sys.argv) <= 1 or sys.argv[1] == self.EXPIRED_CRONTAB:
            self.reset_expired_port()
        elif sys.argv[1] == self.TRIAL_PORT_CRONTAB:
            self.update_trial_port()
        elif sys.argv[1] == self.MERCHANT_CRONTAB:
            self.update_merchant_port()
        elif sys.argv[1] == self.ACCIDENT_RECOVER:
            self.accident_recover()

if __name__ == "__main__" :
    #print sys.argv, len(sys.argv)
    uptp = UpdatePort()
    #uptp.reset_expired_port()
    uptp.client_start()

    logging.info('run finished')
