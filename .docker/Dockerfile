FROM  prooph/php:7.2-cli-xdebug
ENV PATH /usr/local/bin:$PATH
ENV LANG C.UTF-8

RUN apk update && apk upgrade && apk add --no-cache --update ca-certificates supervisor bash curl shadow tini tor \
    && mkdir -p /var/log/supervisor \
    && mkdir -p /etc/supervisor/conf.d \
    && mkdir -p /etc/tor/run \
    && chown -Rh tor. /var/lib/tor /etc/tor/run \
    && chmod 0750 /etc/tor/run \
    && rm -rf /tmp/* /var/cache/apk/*

ADD supervisor/* /etc/supervisor/conf.d/
ADD supervisord.conf /etc/supervisor/supervisord.conf
ADD tor/torrc /etc/tor/torrc

WORKDIR "/var/www/bin"
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]