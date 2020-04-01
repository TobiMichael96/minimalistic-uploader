# minimalistic-uploader

![Docker Image CI](https://github.com/TobiMichael96/minimalistic-uploader/workflows/Docker%20Image%20CI/badge.svg?branch=master)

This simple PHP script will upload any files to your server.

:warning: **Security warning**: There is absolutely no security guaranteed, so you have to take care about this yourself.
 * See the [NGINX docs](https://docs.nginx.com/nginx/admin-guide/security-controls/configuring-http-basic-authentication/) how to secure your NGINX server with basic HTTP authentication.
 
 * There is no check for executable files, so you have to take care of this as well.

## Installation

Just drop the PHP files in the directory of your webserver.

## Configuration

The default configuration uploads the images in the same folder as the PHP file is, you can either change this in the **index.php** itself (not recommended) or rename the **sample.config.php** to **config.php** and change the values as you like.

Also the default configuration will not create any syslinks and print the url of the server where the file is executed.

## Usage options

  * This will upload a file and copy the URL to clipboard:

 ```bash
 curl -F "file=@IMAGE.jpg" https://yoururl.com | xclip -sel clip
 ```
 
 * Or if you are using the NGINX BASIC HTTP AUTHENTICATION:

 ```bash
 curl -u username:password -F "file=@IMAGE.jpg" https://yoururl.com | xclip -sel clip
 ```

## NGINX sample configuration (without HTTPS)

	server {
    	listen 80;
    	listen [::]:80;
    	server_name yoururl.com;

    	root /var/www/html;
		index index.php;

    	location /uploader {
        	auth_basic "Restricted access";
        	auth_basic_user_file /etc/nginx/.htpasswd;

        	try_files $uri $uri/ /index.php?url=$request_uri;
    	} 
		
		location /index.php {
			fastcgi_split_path_info ^(.+\.php)(/.+)$;
			fastcgi_pass unix:/var/run/php7.0-fpm.sock;
			fastcgi_index index.php;
			include fastcgi_params;
		}
	}

