# minimalistic-uploader

This simple PHP script will upload any files to your server.

> :warning: **Security warning**: There is absolutely no security guaranteed, so you have to take care about this yourself.

## Installation

Just drop the PHP files in the directory of your webserver.

## Configuration

The default configuration uploads the images in the same folder as the PHP file is, you can either change this in the 'index.php' itself (not recommended) or rename the 'sample.config.php' to 'config.php' and change the values as you like.

Also the default configuration will not create any syslinks and print the url of the server where the file is executed.

## Usage options

	This will upload a file and copy the URL to clipboard:

	```bash
	curl -F "file=@IMAGE.jpg" https://yoururl.com | xclip -sel clip
	```
  
  
