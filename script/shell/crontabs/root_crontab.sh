#!/bin/bash

# this script should be run as root

# declare the PATH env or use full path cmd, or some cmd will fail to exec
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games

filename=$(date +%Y-%m-%d-%H-%M-%S)
dir_out='/home/alice/root_crontab_out/'
mkdir -p $dir_out
out_file=$dir_out$filename
touch $out_file
/sbin/iptables -L > $out_file
/sbin/iptables -F
