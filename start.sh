#!/bin/bash
app="up.hng.tech"

docker build -t $app .

if docker ps | awk -v app="app" 'NR>1{  ($(NF) == app )  }'; then
    docker stop "$app" && docker rm -f "$app"
fi


docker run -d -p 47789:80 \
    --name=$app \
    -v $PWD/server/nginx.conf:/etc/nginx/nginx.conf \
    -v $PWD/storage/logs/nginx:/var/log/nginx \
    -v $PWD/storage/logs/php7:/var/log/php7 \
    -v $PWD/server/site.conf:/etc/nginx/sites-available/default.conf \
    -v $PWD:/var/www $app


