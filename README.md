
<img src="info/1.jpg" height="300">Pocetna strana
<img src="info/2.jpg" height="300">
<img src="info/3.jpg" height="300">
<img src="info/4.jpg" height="300">
<img src="info/5.jpg" height="300">
<img src="info/6.png" height="300">
<img src="info/7.jpg" height="300">
<img src="info/8.jpg" height="300">
<img src="info/9.jpg" height="300">
<img src="info/10.jpg" height="300">
<img src="info/11.jpg" height="300">
<img src="info/12.jpg" height="300">
<img src="info/13.jpg" height="300">
<img src="info/14.jpg" height="300">
<img src="info/15.jpg" height="300">
<img src="info/16.jpg" height="300">
<img src="info/17.jpg" height="300">
### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-tutorial.localhost
        DocumentRoot /path/to/zf2-tutorial/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/zf2-tutorial/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
