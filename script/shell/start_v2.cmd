#!/bin/bash
#rm old socket manager
if [ -e shadowsocks-alice-manager.sock* ]; then
    rm shadowsocks-alice-manager.sock*
    echo "remove old socket file success"
else
    echo "not found"
fi
/usr/local/bin/ssserver --pid-file ~/shadowsocks.alice.pid --log-file ~/shadowsocks.alice.log  \
        --manager-address ~/shadowsocks-alice-manager.sock  -c shadowsocks.json -d start \
