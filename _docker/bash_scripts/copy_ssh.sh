#!/usr/bin/env bash

if [ ! -f ~/_ssh/id_rsa ]; then
    echo "################################"
    echo "# SSH Key not found!!!"
    echo "# file not found: ${PROJECT_ROOT}\\_ssh\\id_rsa"
    echo "################################"
else
    if [ ! -f ~/.ssh/id_rsa ]; then
        mkdir ~/.ssh
        # Force Unix line endings.
        sed -e 's/\r\n/\n/g' ~/_ssh/id_rsa > ~/.ssh/id_rsa
        chmod -R 400 ~/.ssh
        echo "StrictHostKeyChecking no" >> /etc/ssh/ssh_config
    fi
fi