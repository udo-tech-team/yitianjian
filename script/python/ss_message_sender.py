#!/usr/bin/python
# -*- coding: utf-8 -*-

######################################
#
# @param:  quick_recover
#    script to call remote host send ports info to localhost,
#       localhost gather ports info and add them in ssserver
#
######################################

import socket
import logging
import os
import sys
import time
import traceback
import ConfigParser

cur_dir = os.getcwd()
sys.path.append(cur_dir)
sys.path.append(cur_dir + '/selfmod/')

class SsMessageSender:
    """message sender, send messages from ssserver to yitianjian web server"""
    sock = None
    conf_file = './conf/ss_message_sender.conf'
    conf = None
    # global mark to decide go on or not
    GOON = True

    # param type
    QUICK_RECOVER = 'quick_recover'

    def __init__(self):
      logging.basicConfig(level=logging.DEBUG,
            format='%(asctime)s %(filename)s[%(lineno)s] %(levelname)s %(message)s',
            datefmt='%d %b %Y %H:%M:%S',
            filename='./logs/ss_message_sender.log',
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

    def send_message_to_yitianjian(self, message_str):
        """ send a message to yitianjian web server """
        if not self.GOON:
            logging.warning('GOON is false, stop.')
            return False
        # TODO try send multi times to make sure send success
        cmd = str(message_str)
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

    def client_start(self):
        self.load_conf()
        self.init_sock()
        if len(sys.argv) <= 1 or sys.argv[1] == self.QUICK_RECOVER:
            self.send_message_to_yitianjian(self.QUICK_RECOVER)

if __name__ == "__main__" :
    #print sys.argv, len(sys.argv)
    sender = SsMessageSender()
    sender.client_start()

    logging.info('run finished')
