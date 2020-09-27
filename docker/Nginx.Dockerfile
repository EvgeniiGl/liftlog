FROM nginx

#change default configures on vhost.conf
ADD docker/conf/vhost.conf /etc/nginx/conf.d/default.conf

#define work directory, when we go inside docker this folder will open
WORKDIR var/www/liftlog
