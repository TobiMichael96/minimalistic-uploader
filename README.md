# minimalistic-uploader

![Docker Image CI](https://github.com/TobiMichael96/minimalistic-uploader/workflows/Docker%20Image%20CI/badge.svg?branch=master)

This Docker Image will upload any files to your server.

:warning: **Security warning**: There is absolutely no security guaranteed, so you have to take care about this yourself.
 * There is no check for executable files, so you have to take care of this as well.

## Installation

Pull the Image via ```docker pull ausraster/minimalistic-uploader``` and run it. 

## Configuration

There are some environment variables available:

- PAGE_URL (sets the page url, if not set it tries to get it automatically)
- PAGE_TITLE (sets the page title, default: Uploader)
- FILE_EXTENSION (sets the accepted file extension(s) (divided by *,*, default: jpg)
- UPLOAD_DIR (sets the directory where the files get uploaded to, default: /var/www/html/)
- SYMLINK_DIR (sets the directory for the symlink directory, mandatory when *UPLOAD_DIR* is set)
- CHARACTERS (sets the character pool for the random name, default: AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789)
- NAME_LENGTH (sets the length of the random name, default: 12)


#### Security options

- HTTP_AUTH_LOGIN (sets the username for the nginx auth_basic)
- HTTP_AUTH_PASSWORD (sets the password for the nginx auth_basic)

Both of these must be present in order to use auth_basic.

## Usage options

  * This will upload a file and copy the URL to clipboard:

 ```bash
 curl -F "file=@IMAGE.jpg" https://yoururl.com/uploader | xclip -sel clip
 ```
 
 * Or if you are using the NGINX BASIC HTTP AUTHENTICATION:

 ```bash
 curl -u username:password -F "file=@IMAGE.jpg" https://yoururl.com/uploader | xclip -sel clip
 ```

## NGINX as reverse proxy for the container (without HTTPS)

	server {
    	listen 80;
    	listen [::]:80;
    	server_name yoururl.com;

        location / {
            proxy_pass http://127.0.0.1:8080/;
            proxy_set_header Host $host;
            proxy_set_header Upgrade $http_upgrade;
            proxy_set_header Connection $http_connection;
        }
	}

