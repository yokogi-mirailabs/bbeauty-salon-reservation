FROM nginx:1.23.2-alpine

ENV TZ Asia/Tokyo

COPY ./docker/nginx/*.conf /etc/nginx/conf.d/

WORKDIR /var/www/html
