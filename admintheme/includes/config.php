<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set("display_errors", true);
date_default_timezone_set('Europe/Copenhagen');

$baseUrl        = "http://beatinterior.no/";
$siteName       = "Bea T. Interior";
$adminEmail     = "abhaymilestogo@gmail.com";

$item_limit     = 10; // Pagination item per page //
$adjascent      = 5;  // Max number of pages displayed when there are multiple pages  //
$item_limit_arr = array(10,20,30,40);

if ( $_SERVER['HTTP_HOST']=='localhost' ) {
	 $dbHost     =  'localhost';
	 $dbUsername =  'root';
	 $dbPassword =  '';
	 $dbName     =  'beatinterior_no';
}
else {
	 $dbHost     =  'beatinterior.no.mysql';
	 $dbUsername =  'beatinterior_no';
	 $dbPassword =  'QBvC2fPJ';
	 $dbName     =  'beatinterior_no';
}
$conn = @mysql_connect($dbHost, $dbUsername, $dbPassword);
$conn = 1;
if( $conn ) {
     //echo 'Database Connection OK';
	 @mysql_select_db($dbName) or die(mysql_error());
}
else {
	 echo 'Error in Database Connection';
}