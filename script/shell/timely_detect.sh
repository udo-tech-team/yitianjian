#!/bin/bash

PATH='/usr/local/mysql/bin:/usr/local/php5/bin:/usr/local/php5/bin:/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:/Users/yeweishuai/bin'

# make sure every variable initialized when declare
set -u
# make sure every step success, exit on failure
set -e

user=$(whoami)

detect_process_name='ssserver'
ps -u$user | grep $detect_process_name | grep -v grep
echo 'exists'
