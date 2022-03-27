<?php

function checkEmail($clientEmail){
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
 return $valEmail;
}

function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

function getNavList($classifications) {
    
    $navList = "<a href='/index.php' title='View the PHP Motors home page'>Home</a>";
    
    foreach ($classifications as $classification) {
        $navList .= "<a href='../vehicles/?action=classification&classificationName="
        .urlencode($classification['classificationName']).
        "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a>";
    }
    
    return $navList;
}

function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) {
     $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    }
    $classificationList .= '</select>'; 
    return $classificationList; 
}

// the h2 should be a link, pass the inventory  ID
function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
     $dv .= '<li>';
     $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
     $dv .= '<hr>';
     $dv .= "<h2><a href='../vehicles/index.php?action=vehicleDetails&invId=$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
     $dv .= "<span>$ $vehicle[invPrice]</span>";
     $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
   }

function buildVehiclesDetailsDisplay($vehicle){
    $vehicle['invPrice'] = number_format(
        $vehicle['invPrice'],
        0,
        ".",
        ","
    );
    $dv = '<ul>';
     $dv .= '<li>';
     $dv .= "<img src='$vehicle[invImage]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
     $dv .= '<hr>';
     $dv .= "<h2>" . $vehicle['invMake'] . ' ' . $vehicle['invModel'] . "</h2>";
     $dv .= "<span>$" . $vehicle['invPrice'] . "</span>";
     $dv .= "<hr>";
     $dv .= "<span>" . $vehicle['invDescription'] . "</span>";
     $dv .= "<hr>";
     $dv .= "<span>" . $vehicle['invStock'] . "</span>";
     $dv .= "<hr>";
     $dv .= "<span>" . $vehicle['invColor'] . "</span>";
     $dv .= '</li>';
    $dv .= '</ul>';
    return $dv;
}

?>