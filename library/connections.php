<?php

function dbConnect() {
 $server = 'localhost';
 $dbname= 'phpmotors';
 $username =  'root';
 $password = '';
 $dsn = 'mysql:host='.$server.';port=3306;dbname='.$dbname;
 $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
 // Create the actual connection object and assign it to a variable
 try {
  $link = new PDO($dsn, $username, $password, $options);
  return $link;
 } catch(PDOException $e) {
   header('Location: /view/500.php');
   exit;
 }
}

?>