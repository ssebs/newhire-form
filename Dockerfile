FROM php:apache
RUN apt-get update && apt-get install vim curl python3 python3-pip -y;
RUN pip3 install pyyaml jinja2 request

RUN rm -rf /var/www/html/*

RUN mkdir -p /var/www/html/usr-yml/old
RUN mkdir /var/www/html/bin/
RUN mkdir /var/www/html/templates/

COPY ./src/ /var/www/html/
COPY ./bin/ /var/www/html/bin/
COPY ./templates/ /var/www/html/templates/

RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80:80
