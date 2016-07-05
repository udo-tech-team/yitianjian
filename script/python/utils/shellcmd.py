#!/usr/bin/python
# -*- coding: utf-8 -*-

""" python call shell commands
    show status and outputs
"""

import commands
import sys


def py_call_shell(cmd):
    """ call shell to execute cmd
    """
    status, output = commands.getstatusoutput(cmd)
    print "status: ", status
    for line in output.split('\n'):
        print line

if __name__ == '__main__':
    if len(sys.argv) < 2:
        print 'argv not specified'
        sys.exit(0)
    py_call_shell(sys.argv[1])
