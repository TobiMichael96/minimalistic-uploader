#!/bin/sh

if [ "${HTTP_AUTH_PASSWORD}" != "" ]; then
  if [ "${HTTP_AUTH_LOGIN}" == "" ]; then
    echo "User not defined, going to end now..."
    exit 1
  else
    sed -i "s/#auth_basic/auth_basic/g;" /etc/nginx/nginx.conf
    rm -rf /etc/nginx/.htpasswd
    echo -n $HTTP_AUTH_LOGIN:$(openssl passwd -apr1 $HTTP_AUTH_PASSWORD) >> /etc/nginx/.htpasswd
    echo "Basic auth is on for user ${HTTP_AUTH_LOGIN}..."
  fi
else
  echo "Basic auth is off (HTTP_AUTH_PASSWORD not provided)."
fi

if [ "${UPLOAD_DIR}" != "" ]; then
  mkdir -p $UPLOAD_DIR
  chown nobody:nobody -R $UPLOAD_DIR
  if [ "${SYMLINK_DIR}" != "" ]; then
    mkdir -p $SYMLINK_DIR
    chown nobody:nobody -R $SYMLINK_DIR
  else
    echo "UPLOAD_DIR set but no SYMLINK_DIR set, going to end now..."
    exit 1
  fi
fi

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf