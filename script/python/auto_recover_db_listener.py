#!/usr/bin/python
# -*- coding: utf-8 -*-

import socket
import os
import time
import sys
import logging
import ConfigParser

cur_dir = os.getcwd()
sys.path.append(cur_dir)

import crontab_update_port

#################################
#
#  script run as daemon on yitianjian web server
#  recieve request from ssserver, 
#  data format: PREFIX|CMD
#  PREFIX is predefined between client and server
#  CMD is the command to execute on ssserver
#
#  script functions:
#   1. accept request from remote host
#   2. if remote host requests recover, call accident_recover 
#
#################################

logging.basicConfig(level=logging.DEBUG,
            format='%(asctime)s %(filename)s[%(lineno)d] %(levelname)s %(message)s',
            datefmt='%d %b %Y %H:%M:%S',
            filename='./logs/auto_recover_listener.log',
            filemode='a')

class RecoverListener:
    """ manage ssserver port """
    conf = {}
    conf_file = 'conf/auto_recover_db_listener.conf'
    sock = None
    timeout = 10
    # global mark to decide go on or not
    GOON = True
    QUICK_RECOVER = 'quick_recover'
    # update port class
    uptp = None
    ACCIDENT_RECOVER = 'accident_recover'

    def __init__(self):
        pass

    def load_conf(self):
      if not self.GOON:
          logging.warning('GOON is false, stop.')
          return
      try:

        cf = ConfigParser.ConfigParser()
        cf.read(self.conf_file)
        svr_sec = 'recover_listener'
        self.conf['listen_port'] = cf.get(svr_sec, 'listen_port')
        self.conf['host'] = cf.get(svr_sec, 'host')
        self.conf['password'] = cf.get(svr_sec, 'password')
        self.conf['pass_cmd_seperator'] = cf.get(svr_sec, 'pass_cmd_seperator')
        #self.conf[''] = cf.get(svr_sec, '')
        log_str = 'load conf succ, conf[%s] ' % (self.conf)
        logging.debug(log_str)

      except Exception as e:
        self.GOON = False
        log_str = 'exception occurs[%s]' % (e)
        logging.warning(log_str)

    def init_sock(self):
      """ init socket, listen to client's request"""

      if not self.GOON:
          logging.warning('GOON is false, stop.')
          return

      try:

        # this depends on load_conf
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.sock.bind((self.conf['host'], (int)(self.conf['listen_port'])))
        self.sock.listen(1)
        log_str = 'socket init ok. %s' % (self.sock)
        logging.info(log_str)

      except Exception as e:
        self.GOON = False
        log_str = 'exception occurs[%s]' % (e)
        logging.warning(log_str)

    def init_class(self):
        self.uptp = crontab_update_port.UpdatePort()
        log_str = 'updatePort class instance[%s]' % (self.uptp)
        logging.debug(log_str)

    def exec_remote_cmd(self, cmd_str, remote_ip):
        """act according to cmd_str"""
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return

        if remote_ip is None:
            logging.warning('remote ip none, stop.')
            return

        # set succ default to false
        is_succ = False 
        try:
            # quick_recover
            if cmd_str == self.QUICK_RECOVER:
                ori_second_param = ''
                if len(sys.argv) < 2:
                    sys.argv.append(self.ACCIDENT_RECOVER)
                else:
                    ori_second_param = sys.argv[1]
                    sys.argv[1] = self.ACCIDENT_RECOVER
                log_str = 'sys.argv[%s] cmd_str[%s]' % (sys.argv, cmd_str)
                self.uptp.client_start(remote_ip)
    
                # recover sys param
                if ori_second_param == '':
                    del(sys.argv[1])
                else:
                    sys.arg[1] = ori_second_param

                is_succ = True
        except Exception as e:
            #print e, ", close conn"
            logging.warning(e)

        return is_succ

    def serve_forever(self):
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return
        while True:
            conn, addr = self.sock.accept()
            log_str = '%s addr:%s' % (conn, addr)
            logging.info(log_str)
            while True:
                try:
                    conn.settimeout(self.timeout)
                    data = conn.recv(1506)
                    #print data
                    log_str = 'recv[%s]' % (data)
                    logging.debug(log_str)
                    if data is None or data == '':
                        log_str = 'data is empty,%s' % (addr)
                        logging.warning(log_str)
                        conn.close()
                        break
                    split_arr = data.split(self.conf['pass_cmd_seperator'])
                    logging.debug(split_arr)
                    if split_arr[0] == self.conf['password']:
                        # password match, exec cmd
                        cmd = split_arr[1]
                        res = 'error'
                        # call accident recover
                        if self.exec_remote_cmd(cmd, addr[0]):
                            res = 'ok'
                        conn.sendall(res)
                    else:
                        # password unmatch, send default response
                        log_str = 'recv wrong passwd[%s]' % (split_arr[0])
                        logging.warning(log_str)
                        conn.sendall('404')
                except Exception as e:
                    #print e, ", close conn"
                    logging.warning(e)
                    conn.close()
                    break;
            if conn:
                conn.close()

    def server_start(self):
        # make sure load_conf exec first
        self.load_conf()
        self.init_sock()
        self.init_class()
        self.serve_forever()

if __name__ == "__main__" :
    print "run RecoverListener"
    listener = RecoverListener()
    listener.server_start()
