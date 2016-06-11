#!/bin/bash
#rm old socket manager

# ss working directory
working_dir=$(pwd)'/'

mkdir -p $working_dir

if [ -e ${working_dir}shadowsocks-alice-manager.sock* ]; then
    rm ${working_dir}shadowsocks-alice-manager.sock*
    echo "remove old socket file success"
else
    echo "not found"
fi

# start ss in manager mode
/usr/local/bin/ssserver --pid-file ${working_dir}shadowsocks.alice.pid --log-file ${working_dir}shadowsocks.alice.log  \
        --manager-address ${working_dir}shadowsocks-alice-manager.sock  -c ${working_dir}shadowsocks.json -d start \
