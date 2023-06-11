#!/usr/bin/env bash

docker-compose exec typo3 /bin/bash -c "chmod -R 777 /var/www/html/"
