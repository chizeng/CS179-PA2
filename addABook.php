<?php
    
    /*
     * adds a book to the suggested list 
     * for Ben B.'s book club
     *
     * By Chi Zeng, CS179, Spring 2012
     *
     */
    
    require_once('core.php');
    
    // load template data
    $data['title'] = "Add a Book";
    
    // initiate default inputs
    $bookTitle = "";
    $bookAuthor = "";
    $bookURL = "";
    
    // if form was submitted, process form, else load empty form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // retrieve data
        $bookTitle = clean($_POST['title']);
        $bookAuthor = clean($_POST['author']);
        $bookURL = clean($_POST['url']);
        
        // test if input is not empty (and url exists)
        if (empty($bookTitle))
            $formErrors['title'] = "Title required.";
        if (empty($bookAuthor))
            $formErrors['author'] = "Author required.";
        if ( ! empty($bookURL)) {
            if (file($bookURL) === false)
                $formErrors['url'] = "URL not found.";
            else if ( ! is_array(getimagesize($bookURL)))
                $formErrors['url'] = "URL is not an image.";
        }
            
        // check if any text is too long
        if (count($bookTitle) > MAX_BOOK_TITLE)
            $formErrors['title'] = "Title over ".MAX_BOOK_TITLE." characters.";
        if (count($bookAuthor) > MAX_BOOK_AUTHOR)
            $formErrors['author'] = "Author over ".MAX_BOOK_AUTHOR." characters.";
        if (count($bookURL) > MAX_BOOK_URL)
            $formErrors['url'] = "URL over ".MAX_BOOK_URL." characters.";
        
        // if form has errors, go back to form, else load success page
        if (count($formErrors) > 0) {
            require_once('templates/addABook.php');
        } else {
            addBook($bookTitle, $bookAuthor, $bookURL);
            $data['title'] = "Suggested Books";
            $data['message'] = "<span class='bookTitle'>$bookTitle</span> successfully added.";
            require_once('templates/suggestedBooks.php');
        }
    } else {
        require_once('templates/addABook.php');
    }
    
?>