#!/usr/bin/python
import sys
import hashlib
import time
import socket
import logging
import os
import ConfigParser
import traceback

#import selfdefined module
cur_dir = os.getcwd()
sys.path.append(cur_dir + '/selfmod/')
#sys.path.append('/home/alice/shadowsocks/script/python/selfmod/')
import Database

class YitianjianPortManager:
    # store key/value -> domain/socket
    sock_map = {}
    conf_file = 'conf/yitianjian_port_manager.conf'
    domain_ratio_arr = []
    DOMAIN_SEPERATOR = ','
    DOMAIN_RATIO_SEPERATOR = '@'
    COMMA = ','
    GOON = True
    total_ratio = 0
    dbObj = None
    domain_ip_dict = {'gso.hk':'104.207.153.8'}
    multi_domain_arr = []

    def __init__(self) :
      logging.basicConfig(level=logging.DEBUG,
            format='%(asctime)s %(levelname)s[%(lineno)s] %(message)s',
            datefmt='%d %b %Y %H:%M:%S',
            filename='./logs/yitianjian_port_manager.log',
            filemode='a')

    def init_class(self):
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return
        try:
            mysqlObj = Database.MysqlObj()
            self.dbObj = mysqlObj
        except Exception as e:
            self.GOON = False
            log_str = 'exception occurs [%s]' % (e)
            logging.warning(log_str)

    def load_conf(self):
      if not self.GOON:
          logging.warning('GOON is false, stop.')
          return

      try:
        cf = ConfigParser.ConfigParser()
        cf.read(self.conf_file)
        clt_sec = 'yitianjian_port_manager'
        self.conf = {}
        self.conf['remote_port'] = cf.get(clt_sec, 'remote_port')
        self.conf['pass_cmd_seperator'] = cf.get(clt_sec, 'pass_cmd_seperator')
        self.conf['password'] = cf.get(clt_sec, 'password')
        self.conf['debug_mode'] = cf.get(clt_sec, 'debug_mode')
        self.conf['domain'] = cf.get(clt_sec, 'domain')
        self.conf['default_domain'] = cf.get(clt_sec, 'default_domain')
        self.conf['multi_domain_enable'] = cf.get(clt_sec, 'multi_domain_enable')
        self.conf['multi_domain2db_enable'] = cf.get(clt_sec, 'multi_domain2db_enable')
        self.conf['ss_encrypt_type'] = cf.get(clt_sec, 'ss_encrypt_type')
        self.conf['first_port_password'] = cf.get(clt_sec, 'first_port_password')
        self.conf['every_port_insert2multi_ssserver'] = cf.get(clt_sec, 'every_port_insert2multi_ssserver')
        self.conf['max_port_add_once'] = int(cf.get(clt_sec, 'max_port_add_once').strip())

        port_range_arr = cf.get(clt_sec, 'port_range').split(self.COMMA)
        self.conf['port_from'] = int(port_range_arr[0].strip())
        self.conf['port_to'] = int(port_range_arr[1].strip())

        # port range err or exceed max port num
        port_range_err = self.conf['port_to'] < self.conf['port_from']
        self.conf['port_total'] = self.conf['port_to'] - self.conf['port_from']
        exceed_max_err =  self.conf['port_total'] > self.conf['max_port_add_once']

        if port_range_err or exceed_max_err:
                log_str = 'port_from[%d] port_to[%d] max_port_add_once[%d]' % \
                        (self.conf['port_to'], self.conf['port_from'], \
                                self.conf['max_port_add_once'])
                logging.warning(log_str)
                self.GOON = False

        #self.conf[''] = cf.get(clt_sec, '')
        log_str = 'load_conf succ, %s' % (self.conf)
        logging.debug(log_str)

        # transform domain conf, domain_name@ratio
        self.domain_ratio_arr = []
        domain_arr = self.conf['domain'].split(self.DOMAIN_SEPERATOR)
        domains_num = len(domain_arr)
        self.total_ratio = 0
        for domain_at_ratio in domain_arr:
            tmp_arr = domain_at_ratio.strip().split(self.DOMAIN_RATIO_SEPERATOR)
            domain_ratio_pair = {"domain": tmp_arr[0].strip(), "ratio":int(tmp_arr[1].strip())}
            self.domain_ratio_arr.append(domain_ratio_pair)
            self.total_ratio += domain_ratio_pair.get('ratio')
            self.multi_domain_arr.append(tmp_arr[0].strip())
        multi_domain_info = 'multi domain and ratio info:%s, total:%d' \
                % (self.domain_ratio_arr, self.total_ratio)
        logging.debug(multi_domain_info)


      except Exception as e:
        self.GOON = False
        log_str = 'exception occurs[%s]' % (e)
        logging.warning(log_str)

    # @param domain,in. a domain related to port of a record
    # @return socket, out.
    def get_socket(self, domain):
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return None
        # mutil domain not enabled, rewrite to default domain
        if self.conf['multi_domain_enable'] == '0':
            domain = self.conf['default_domain']

        if domain is None:
            logging.warning('param domain None')
            return None
        sock = self.sock_map.get(domain)
        # domain related host not connected
        if sock is None:
            try:
                # from domain get ip and connect
                addrinfo = socket.getaddrinfo(domain, None)
                remote_ip = addrinfo[0][4][0]
                sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
                seek_dict_ip = self.domain_ip_dict.get(domain)
                if not seek_dict_ip is None:
                    remote_ip = seek_dict_ip
                sock.connect((remote_ip, int(self.conf['remote_port'])))

                # add to map
                self.sock_map[domain] = sock
            except Exception as e:
                log_str = 'exception occurs [%s]' % (e)
                logging.warning(log_str)

        return sock

    def generate_next_md5(self, former_md5):
        return hashlib.md5(former_md5).hexdigest()

    def get_domain_name(self, num):
        """  if multi_domain_enble not true: 
                return default_domain.
            else:
                domain_a@5, domain_b@8, domain_c@2 total = 15
                num % total = x, if x < 5, then return domain_a, else if
                    x < 13, then return domain_b, else return domain_c
        """
        # multi domain 2db not enabled
        if self.conf['multi_domain2db_enable'] == '0':
            return self.conf['default_domain']

        rest = num % self.total_ratio
        domain_num = len(self.domain_ratio_arr)
        cur_sum = 0
        for i in range(0, domain_num):
            cur_sum += self.domain_ratio_arr[i].get('ratio')
            if rest < cur_sum:
                return self.domain_ratio_arr[i].get('domain')

        # normally will not reach here
        return self.conf['default_domain']

    def new_port2db(self):
        """generate port and insert into db
        """
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return
        # mysql obj
        try:
            former_md5 = self.conf['first_port_password']
            encrypt_type = self.conf['ss_encrypt_type']
            status = 0
            uid = 0
            mtid = 0
            ssip = '104.207.153.8'
            for ssport in range(self.conf['port_from'], self.conf['port_to']):
                cur_md5 = self.generate_next_md5(former_md5)
                cur_port_password = cur_md5[:6]
                sql_query = 'insert into cake_ports (ssport, sshost, ssencrypt,\
                        ssip, sspass, created, modified) values (%d, "%s", "%s",\
                        "%s", "%s", now(), now())' % \
                        (ssport, self.get_domain_name(ssport),\
                        encrypt_type, ssip, cur_port_password)

                log_info = 'sql[%s] for port[%d]' % (sql_query, ssport)
                logging.debug(log_info)

                exec_res = self.dbObj.exec_query(sql_query)
                log_info = 'port [%d] affected rows: %d' % (ssport, exec_res)
                logging.debug(log_info)

                # record cur pass as former for next port
                former_md5 = cur_md5
        except Exception as e:
            self.GOON = False
            log_str = 'exception occurs [%s]' % (e)
            logging.warning(log_str)

    def finallize(self):
        """ return resources, close sockets
        """
        # default domain socket
        sock = self.sock_map.get(self.conf['default_domain'])
        if not sock is None:
            self.try_close_socket(sock)

        # multi domain socket
        for domain_ratio_pair in self.domain_ratio_arr:
            domain = domain_ratio_pair.get('domain')
            sock = self.sock_map.get(domain)
            if not sock is None:
                self.try_close_socket(sock)

    def try_close_socket(self, sock):
        if sock is None:
            return
        try:
            sock.close()
        except Exception as e:
            log_str = 'exception occurs [%s]' % (e)
            logging.warning(log_str)

    def insert_port(self, port, domain, password):
        """ insert a port in ssserver, port/domain/password as param"""
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return False

        sock = self.get_socket(domain)
        if sock is None:
            log_str = 'sock[%s] err' % (sock)
            logging.warning(log_str)
            return False

        # insert an account, with port / password
        # 1. remove port 
        cmd = 'remove:{"server_port":' + str(port) + '}'
        net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + cmd
        sock.sendall(net_str)
        exec_res = sock.recv(1024)

        log_str = '[%s] exec res[%s]' % (net_str, exec_res)
        if exec_res != 'ok':
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        # 2. add the removed port 
        cmd = 'add:{"server_port":' + str(port) + ',"password":"' + password + '"}'
        net_str = self.conf['password'] + self.conf['pass_cmd_seperator'] + cmd
        sock.sendall(net_str)
        exec_res = sock.recv(1024)

        log_str = '[%s] exec res[%s]' % (net_str, exec_res)
        if exec_res != 'ok':
            logging.critical(log_str)
            return False
        else:
            logging.info(log_str)

        return True

    def insert_into_remote_ssserver(self):
        # 1. get all records
        # 2. insert one by one
        #  id,ssport,sshost,ssencrypt,sspass
        sql_query = 'select id,ssport,sshost,ssencrypt,sspass from cake_ports \
            where ssport >= %d and ssport < %d order by id desc limit %d\
            ' % (self.conf['port_from'], self.conf['port_to'], \
            self.conf['port_total'])
        rec_count, all_res = self.dbObj.find_all(sql_query)
        log_info = "query[%s] count[%d] " % (sql_query, rec_count)
        logging.info(log_info)
        try:
            succ_count = 0
            if self.conf['every_port_insert2multi_ssserver'] == '0':
                for rec in all_res:
                # every port insert into single domain
                    #  param: port, domain, pass
                    insert_res = self.insert_port(rec[1], rec[2], rec[4]) 
                    log_str = 'id[%d] port[%d] is_succ[%s]' % \
                            (rec[0], rec[1], insert_res)
                    logging.warning(log_str)
                    if insert_res:
                        succ_count += 1
                # every port insert into multi domain
            else:
                for domain in self.multi_domain_arr:
                    for rec in all_res:
                        insert_res = self.insert_port(rec[1], domain, rec[4]) 
                        log_str = 'id[%d] port[%d] is_succ[%s]' % \
                                (rec[0], rec[1], insert_res)
                        logging.warning(log_str)
                        if insert_res:
                            succ_count += 1

            log_str = "finished insert. total[%s] succ[%s]" \
                        % (rec_count, succ_count)
            logging.info(log_str)
        except Exception as e:
            log_str = 'exception occurs, [%s] sys[%s] traceback[%s]' \
                    % (e, sys.exc_info(), traceback.print_exc())
            logging.warning(log_str)

    def main():
        # accept shell param and act according to params
        pass

if __name__ == '__main__':
    ytj_pm = YitianjianPortManager()
    ytj_pm.load_conf()
    ytj_pm.init_class()
    ytj_pm.new_port2db()
    ytj_pm.insert_into_remote_ssserver()
    ytj_pm.finallize()
