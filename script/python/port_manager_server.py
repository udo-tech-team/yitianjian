#!/usr/bin/python
# -*- coding: utf-8 -*-

import socket
import os
import time
import sys
import logging
import ConfigParser

#################################
#
#  script run as daemon on ssserver
#  recieve request from client, 
#  data format: PREFIX|CMD
#  PREFIX is predefined between client and server
#  CMD is the command to execute on ssserver
#
#  script functions:
#   1. add port request
#   2. update port request
#
#################################

class PortManagerServer:
    """ manage ssserver port """
    conf = {}
    cli = None
    conf_file = 'conf/ssserver.manager.conf'
    sock = None
    timeout = 10

    def __init__(self):
        logging.basicConfig(level=logging.DEBUG,
            format='%(asctime)s %(filename)s[%(lineno)d] %(levelname)s %(message)s',
            datefmt='%d %b %Y %H:%M:%S',
            filename='./logs/port_manager_server.log',
            filemode='a')

    def load_conf(self):
        cf = ConfigParser.ConfigParser()
        cf.read(self.conf_file)
        svr_sec = 'socket_server'
        self.conf['listen_port'] = cf.get(svr_sec, 'listen_port')
        self.conf['host'] = cf.get(svr_sec, 'host')
        self.conf['password'] = cf.get(svr_sec, 'password')
        self.conf['pass_cmd_seperator'] = cf.get(svr_sec, 'pass_cmd_seperator')
        self.conf['local_socket_file'] = cf.get(svr_sec, 'local_socket_file')
        self.conf['connect_socket_file'] = cf.get(svr_sec, 'connect_socket_file')
        #self.conf[''] = cf.get(svr_sec, '')

    def init_cli(self):
        """ init command_line to enable communication
        between PortManagerServer and ssserver"""
        # this should be called after load_conf
        self.cli = socket.socket(socket.AF_UNIX, socket.SOCK_DGRAM)
        os.system("rm " + self.conf["local_socket_file"])
        self.cli.bind(self.conf["local_socket_file"])
        self.cli.connect(self.conf["connect_socket_file"])
        self.cli.send(b'ping')
        print self.cli.recv(1506)

    def init_sock(self):
        """ init socket, listen to client's request"""
        # this depends on load_conf
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.sock.bind((self.conf['host'], (int)(self.conf['listen_port'])))
        self.sock.listen(1)
        log_str = 'socket init ok. %s' % (self.sock)
        logging.info(log_str)

    def serve_forever(self):
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
                        self.cli.send(cmd)
                        res = self.cli.recv(1506)
                        conn.sendall(res)
                    else:
                        # password unmatch, send default response
                        log_str = 'recv passwd[%s]' % (split_arr[0])
                        logging.warning(log_str)
                        conn.sendall('200')
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
        self.init_cli()
        self.init_sock()
        self.serve_forever()

if __name__ == "__main__" :
    print "run PortManager"
    pms = PortManagerServer()
    pms.server_start()
    print pms.conf
    logging.debug(pms.conf)
