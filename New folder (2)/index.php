<?php
// session_start();
require_once($_SERVER['DOCUMENT_ROOT'] .'./library/connections.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'./model/mainModel.php');
include_once($_SERVER['DOCUMENT_ROOT'] . './library/functions.php');
error_reporting(-1);
ini_set('display_errors', 'true');

$classifications = getClassifications();
$navList = getNavList($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

if(isset($_COOKIE['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action){
  case 'Classic':
    //include $_SERVER['DOCUMENT_ROOT'] .'./view/classic.php';
   break;
  case '500':
    include $_SERVER['DOCUMENT_ROOT'] .'./view/500.php';
    break;
  default:
    // $_SESSION['loggedin'] = TRUE;
    include $_SERVER['DOCUMENT_ROOT'] .'./view/home.php';
    break;
 }

?>