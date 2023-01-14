FROM alpine:3.5 as intermediate

RUN apk update
RUN apk add git

RUN git clone --single-branch https://github.com/Ltairx/prestashop

FROM prestashop/prestashop:1.7.8.7

ARG DATABASE_HOST=mariadb
ARG DATABASE_PORT=''
ARG DATABASE_NAME=prestashop
ARG DATABASE_USER=prestashopuser@localhost
ARG DATABASE_PASSWORD=test
ARG DATABASE_PREFIX=ps_

COPY --from=intermediate /prestashop .
RUN chmod -R 755 .
RUN chown -R www-data:www-data /var/www/html
RUN rm -rf install/

COPY ./parameters.php /var/www/html/app/config/parameters.php
COPY ./.htaccess /var/www/html/.htaccess
COPY ./000-default.conf /ssl/000-default.conf

#COPY --from=intermediate /prestashop/ssl/000-default.conf /ssl/000-default.conf
#COPY --from=intermediate /prestashop/ssl/000-default-ssl.conf /ssl/000-default-ssl.conf
COPY --from=intermediate /prestashop/ssl.sh .

#RUN service apache2 restart

EXPOSE 80
EXPOSE 443
CMD ["bash", "ssl.sh"]
