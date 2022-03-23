<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'./library/connections.php';

function getClassifications() {
    $db = dbConnect(); 
    $sql = 'SELECT classificationName FROM carclassification ORDER BY classificationName ASC'; 
    $stmt = $db->prepare($sql);
    $stmt->execute(); 

    $classifications = $stmt->fetchAll(); 
    $stmt->closeCursor(); 

    return $classifications;
}

function getClassificationsWithId() {
    $db = dbConnect(); 
    $sql = 'SELECT classificationName, classificationId FROM carclassification ORDER BY classificationName ASC'; 
    $stmt = $db->prepare($sql);
    $stmt->execute(); 

    $classifications = $stmt->fetchAll(); 
    $stmt->closeCursor(); 

    return $classifications;
}

?>