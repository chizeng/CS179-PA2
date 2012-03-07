<?php

    /**
     * removeFromSuggested.php
     * removes a book from the suggested list
     */
        
    // get core functionalities
    require_once('../core.php');
    
    // get data
    $bookID = clean($_POST['bookID']);
    if (removeBook($bookID))
        echo "Successfully removed book with id $bookID.";
    
?>