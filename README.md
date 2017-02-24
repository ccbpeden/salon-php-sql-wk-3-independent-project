# **Salon Manager**
#### Charles Peden, 2/24/2017

&nbsp;
## Description
A program that allows a hypothetical salon owner to keep track of stylists and their clients.

&nbsp;
## Specifications

|Behavior|Input|Output|Justification|
|--------|-----|------|-------|
Program successfully instantiates classes stylist and client, getters are operational.
Program can save instances of the stylist and client classes to a database.
Program sanitizes stylist information before inserting into database.
Program can extract all instances of stylist and client classes from database.
Program 'desanitizes' stylist information after extracting from database
Program can delete all instances of stylist and client classes from database.
Program can successfully associate multiple clients with a specific stylist.
Program can search for clients and stylists by unique id.
Program can search for clients by stylist id.
Program can update instances of stylist and client in the database.
Program user can view all current stylists in a web interface.
Program user can add stylists in web interface.
Program user can edit stylists in web interface.
Program user can associate new clients with a specific stylist in web interface.
Program user can view all clients associated with specific stylist in web interface.
Program user can edit specific client information in web interface.
Program user can delete specific clients in web interface.
Program user can delete a stylist and all clients associated w/ that stylist in web interface.

## MYSQL commands to replicate DB:
CREATE DATABASE hair_salon;
USE hair_salon;
CREATE TABLE stylists (stylist_last_name VARCHAR (255), stylist_first_name VARCHAR (255), specialty VARCHAR (255), id serial PRIMARY KEY);
CREATE TABLE clients (client_last_name VARCHAR (255), client_first_name VARCHAR (255), stylist_id INT, id serial PRIMARY KEY);





&nbsp;
## Setup/Installation Requirements
##### _To view and use this application:_
* You will need the dependency manager Composer installed on your computer to use this application. Go to [getcomposer.org] (https://getcomposer.org/) to download Composer for free.
* Go to my [Github repository] (https://github.com/ccbpeden/salon-php-sql-wk-3-independent-project)
* Download the zip file via the green button
* Unzip the file and open the **_salon-php-sql-wk-3-independent-project-master_** folder
* Open Terminal, navigate to **_salon-php-sql-wk-3-independent-project-master_** project folder, type **_composer install_** and hit enter
* Navagate Terminal to the **_salon-php-sql-wk-3-independent-project_/web_** folder and set up a server by typing **_php -S localhost:8000_**
* Install and configure Mamp, MySQL, and PDO.
* Activate Mamp and Start Servers
* Type /Applications/MAMP/Library/bin/mysql --host=localhost -uroot proot
* In a web browser, browse to localhost:888/phpmyadmin.
* Click the import tab in the phpmyadmin gui and select the zipped database included in the project folder.
* The application will load and be ready to use!
* Type **_localhost:8000_** into your web browser

&nbsp;
## Known Bugs
* No known bugs

&nbsp;
## Technologies Used
* PHP
* Silex
* Twig
* Composer
* Bootstrap
* CSS
* HTML

&nbsp;
_If you have any questions or comments about this program, you can contact me at [ccbpeden@warpmail.net](mailto:ccbpeden@warpmail.net)._

Copyright (c) 2017 Charles Peden &

This software is licensed under the GPL license
