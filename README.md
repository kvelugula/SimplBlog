SimplBlog
=========

Simple Blog Demo using PHP

Requirements
============

* Make sure that PHP version is >= 5.3 and MySQL Server 5+ is installed 
* MySQLi Extension is also needed

Configuration
----
* Extract the contents of the archive to a folder in the web server (say C:\apache\htdocs\TestBlog\ pointing to http://localhost/TestBlog/)
* Create a new DB in the MySQL server and name is as "blogdb"
* Create a new user names "sqluser" and set password as "password"
* Alternatively, if there is an existing DB and user credentials, they can be configured in ./TestBlog/lib/appconfig.php
* Connect to MySQL server and establish a connection to the "blogdb" database
* Execute ./TestBlog/install/db-setup.sql
* Test the blog by opening the appropriate URL in the web browser - example http://localhost/TestBlog/


