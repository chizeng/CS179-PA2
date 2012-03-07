<?php

    /**
     * listBooks.php
     * lists books passed in via JSON
     */
        
    // get core functionalities
    require_once('../core.php');
    
    // get all book ids
    $processedBookIDs = str_replace('\\"', '', $_POST['books']);
    $bookIDs = json_decode($processedBookIDs);
    
    // get a resource of books from a list of book IDs.
    displayBooks(retrieveBookResource($bookIDs));
?>