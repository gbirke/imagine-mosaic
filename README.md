# Mirror mosaic with Imagine library

This script uses the [Imagine library][1] to create four mosaic tiles where the 
original image is mirrored horizontally and vertically to create four seamless 
tiles.

## Installation
To install the Imagine library, use [Composer][2]: 

    php composer.phar install

## Usage
Use the following command line:

   php mosaic.php &lt;image.jpg&gt;

This will create four new image files from `<image.jpg>` where the name 
designates the position of the original image.


[1]: https://github.com/avalanche123/Imagine
[2]: http://getcomposer.org/

