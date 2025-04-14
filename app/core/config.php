<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	/** database config **/
	define('DBNAME', 'green-lease');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', dirname(dirname(__FILE__)));
	define('URLROOT', 'http://localhost/Green-Lease/public');
} else {
	/** database config **/
	define('DBNAME', 'green_lease');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.yourwebsite.com');
}

define('APP_NAME', "My Webiste");
define('APP_DESC', "Best website on the planet");

/** true means show errors **/
define('DEBUG', true);
