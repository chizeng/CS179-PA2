<?php
    require_once('core.php');
    
    // load template data
    $data['title'] = "Suggested Books";
    
    // if there's a book to remove, then do so now
    if (array_key_exists('bookIDToRemove', $_GET)) {
        $book = retrieveBook(clean($_GET['bookIDToRemove']));
        if ($book) {
            removeBook($book->id);
            $data['message'] = "<u>{$book->title}</u> successfully removed.";
            $data['bookRemovedID'] = $book->id;
        }
    }

    require_once('templates/suggestedBooks.php');
?>