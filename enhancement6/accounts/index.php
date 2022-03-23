<?php
// should this even be here??
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . './model/accountsModel.php');
include_once($_SERVER['DOCUMENT_ROOT'] . './library/connections.php');
include_once($_SERVER['DOCUMENT_ROOT'] . './library/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'./model/mainModel.php');

$classifications = getClassifications();
$navList = getNavList($classifications);

    $action = filter_input(INPUT_POST, 'action');
        if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
        }
    switch ($action) {
        case 'login':
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientEmail = checkEmail($clientEmail);
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $passwordCheck = checkPassword($clientPassword);

            // Run basic checks, return if errors
            if (empty($clientEmail) || empty($passwordCheck)) {
                $_SESSION['message'] = '<p class="notice">Please provide a valid email address and password.</p>';
                include '../view/login.php';
                exit;
            }
  
            $clientData = getClient($clientEmail);

            $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);

            if(!$hashCheck) {
                $_SESSION['message'] = '<p class="notice">Please check your password and try again.</p>';
                include '../view/login.php';
                exit;
            }
            $_SESSION['loggedin'] = TRUE;

            array_pop($clientData);
            $_SESSION['clientData'] = $clientData;
            include '../view/admin.php';
            exit;
        break;
        case 'register':
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_EMAIL));
            
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);

            $existingEmail = checkExistingEmail($clientEmail);
            if($existingEmail){
                $_SESSION['message'] = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
                include '../view/login.php';
                exit;
               }

            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
                $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
                include $_SERVER['DOCUMENT_ROOT'] .'./view/register.php';
                exit; 
               }

            // Send the data to the model
            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
            
            if($regOutcome === 1){
                setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
                $_SESSION['message'] = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
                include $_SERVER['DOCUMENT_ROOT'] .'./view/login.php';
                exit;
               } else {
                $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
                include $_SERVER['DOCUMENT_ROOT'] . './view/register.php';
                exit;
               }

            break;
        case 'admin':
            include $_SERVER['DOCUMENT_ROOT'] . './view/admin.php';
        break;
        case 'logout':
            session_unset();
            session_destroy();
            include '../view/home.php';
            break;
        case 'Login':
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientEmail = checkEmail($clientEmail);
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $passwordCheck = checkPassword($clientPassword);

            // Run basic checks, return if errors
            if (empty($clientEmail) || empty($passwordCheck)) {
                $_SESSION['message'] = '<p class="notice">Please provide a valid email address and password.</p>';
                include '../view/login.php';
                exit;
            }
  
            $clientData = getClient($clientEmail);

            $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);

            if(!$hashCheck) {
                $_SESSION['message'] = '<p class="notice">Please check your password and try again.</p>';
                include '../view/login.php';
                exit;
            }
            $_SESSION['loggedin'] = TRUE;

            array_pop($clientData);
            $_SESSION['clientData'] = $clientData;
            include '../view/admin.php';
            exit;
        break;
        default:
            echo $action;
            break;
       }

?>