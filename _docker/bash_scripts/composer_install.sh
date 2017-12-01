#!/usr/bin/env bash

cd /opt/project/oauth2

# Build the the code if needed.
if [ ! -f composer.lock ]; then
    echo "Composer Lock Not found Building"
    composer -n install
    composer development-enable
fi

