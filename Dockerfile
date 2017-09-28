FROM creativitykills/nginx-php-server:1.1.2
MAINTAINER Neo Ighodaro <neo@hotels.ng>
ENV TZ=Africa/Lagos
ENV PRODUCTION=1
RUN apk add --update --no-cache tzdata && \
    ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
