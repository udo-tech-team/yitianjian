#!/usr/bin/python
# -*- coding: utf-8 -*-

import socket
import hashlib
import logging
import os
import sys
import time
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
        #self.conf[''] = cf.get(clt_sec, '')
        log_str = 'load_conf succ, %s' % (self.conf)
        logging.debug(log_str)
      except Exception as e:
        self.GOON = False
        log_str = 'exception occurs[%s]' % (e)
        logging.warning(log_str)

    def init_sock(self):
      if not self.GOON:
          logging.warning('GOON is false, stop.')
          return
      try:
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.sock.connect((self.conf['remote_ip'], (int)(self.conf['remote_port'])))
        log_str = 'init_sock succ, %s' % (self.sock)
        logging.debug(log_str)
      except Exception as e:
        self.GOON = False
        log_str = 'exception occurs[%s]' % (e)
        logging.warning(log_str)

    def reset_expired_port(self):
      """reset expired port[update status/uid/expire/sspass fields]"""
      # first update status/uid, so record will not show in ucenter
      # second change sspass, so the account is invalid for formmer user
      if not self.GOON:
          logging.warning('GOON is false, stop.')
          return
      try:
        self.dbObj = Database.MysqlObj()
        time_now = time.strftime(self.time_format, time.localtime(time.time()))
        sql_query = 'select * from cake_ports where expire <= "' + time_now + '"'
        count, all_res = self.dbObj.find_all(sql_query)
        log_str = 'query[%s] record count[%s]' % (sql_query, count)
        logging.info(log_str)
        for rec in all_res:
            #rec(is, ssport,sshost,ssencrypt,sspass,status,created,modified,uid,sip,expire)
            #print rec[0], rec[4]
            log_str = '%s get rec[%s]' % ('cake_ports', rec)
            logging.info(log_str)

            # update cake_ports
            update_query = 'update cake_ports set status = 0, uid = 0, expire = null where id = ' + str(rec[0])
            #exec_res = 1
            exec_res = self.dbObj.exec_query(update_query)
            log_str = '[%s] exec res[%s]' % (update_query, exec_res)
            if exec_res < 1:
                logging.critical(log_str)
                continue
            else:
                logging.info(log_str)

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
                continue
            else:
                logging.info(log_str)

            old_pass = rec[4]
            new_pass = self.get_next_sspass(old_pass)
            cmd = 'add:{"server_port":' + str(rec[1]) + ',"password":"' + new_pass + '"}'
            net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + cmd
            self.sock.sendall(net_str)
            exec_res = self.sock.recv(1024)

            log_str = '[%s] exec res[%s]' % (net_str, exec_res)
            if exec_res != 'ok':
                logging.critical(log_str)
                continue
            else:
                logging.info(log_str)

            # update cake_ports
            # update_query = 'update cake_ports set sspass="' + new_pass + '" where id = ' + str(rec[0])
            update_query = 'update cake_ports set sspass="%s", modified=now() where id=%s' % (new_pass, rec[0])
            exec_res = self.dbObj.exec_query(update_query)
            log_str = '[%s] exec res[%s]' % (update_query, exec_res)
            if exec_res < 1:
                logging.critical(log_str)
                continue
            else:
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

    def client_start(self):
        self.load_conf()
        self.init_sock()
        self.reset_expired_port()

if __name__ == "__main__" :
    uptp = UpdatePort()
    #uptp.reset_expired_port()
    uptp.client_start()

    logging.info('run reset_expired_port finished')
