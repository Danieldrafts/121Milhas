FROM wyveo/nginx-php-fpm:latest
WORKDIR /usr/share/nginx/
RUN rm -rf /usr/share/nginx/html
RUN rm -r /etc/nginx/conf.d/default.conf
RUN ln -s /usr/share/nginx/nginx.conf /etc/nginx/conf.d/default.conf
#RUN ln -s /usr/share/nginx/public html
RUN chown -R nginx:nginx /usr/share/nginx
#RUN chown -R nginx:nginx /usr/share/nginx/bootstrap/cache




