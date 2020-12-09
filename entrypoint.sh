#!/bin/sh

if [ "${HTTP_AUTH_PASSWORD}" != "" ]; then
  if [ "${HTTP_AUTH_LOGIN}" == "" ]; then
    echo "User not defined, going to end now..."
    exit 1
  else
    sed -i "s/#auth_basic/auth_basic/g;" /etc/nginx/nginx.conf
    rm -rf /etc/nginx/.htpasswd
    echo -n $HTTP_AUTH_LOGIN:$(openssl passwd -apr1 $HTTP_AUTH_PASSWORD) >> /etc/nginx/.htpasswd
    echo "Basic auth is on for user ${HTTP_AUTH_LOGIN}."
  fi
else
  echo "Basic auth is off (HTTP_AUTH_PASSWORD not provided)."
fi

if [ ! -d /var/www/html/images ]; then
  mkdir -p /var/www/html/images
fi
chown nobody:nobody -R /var/www/html/images

if [ "${FILE_EXTENSION}" != "" ]; then
  echo "Accepted file extension(s) set to: $FILE_EXTENSION"
else
  echo "Accepted file extension automatically set to jpg."
fi

if [ -z "${RESIZE_IMG}" ]; then
  echo "Images will be resized to ${RESIZE_IMG}%."
else
  echo "Images will not be resized."
fi

if [ -z "${COMPRESS_IMG}" ]; then
  echo "Images will be compressed to ${COMPRESS_IMG}."
else
  echo "Images will not be compressed."
fi

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf > /dev/null
