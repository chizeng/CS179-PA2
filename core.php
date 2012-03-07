<?php

    /**
     * core.php
     * contains key controller functionality for book app to work
     */
        
    // Constants
    define('SITE_NAME', 'Ben B.\'s Book Club');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'cs179');
    define('DB_PASSWORD', 'cs179pa2');
    define('DB_NAME', 'cs179pa2');
    define('MAX_BOOK_TITLE', 127);
    define('MAX_BOOK_AUTHOR', 127);
    define('MAX_BOOK_URL', 511);
    define('MAX_COMMENT', 511);
    // global variables
    $data = array();
    $formErrors = array();

    if (!(mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) 
          && mysql_select_db(DB_NAME)))
        die("Error: Failed to connect to database.");
     
    /*
     * exits app due to mysql error
     */
    function mysqlDie() {
        die('Database Error: ' . mysql_error());
    }
        
    /*
     * executes sql with error checking
     */
    function doSql($sql) {
        $query = mysql_query($sql);
        if (!$query) 
            mysqlDie();
        else
            return $query;
    }
    
    /*
     * escapes double quotes only
     */
    function slashdoubles($input) {
        return str_replace('"', '\"', $input);
    }
    
    /*
     * just gets numbers out of a string
     */
    function numbersOnly($input) {
        return preg_replace("/[^0-9]/", '', $input);
    }
        
    /*
     * removes excess back slashes
     */
    function trill($input) {
        $beGone = array("\\\\\\'", '\\\\\\\\"', '\\\\\\\\');
        $beAdded = array("'", '\"', '\\\\');
        return str_replace($beGone, $beAdded, $input);
    }

    /*
     * adds a new book
     */
    function addBook($title, $author, $link) {
        doSql("INSERT INTO books VALUES (0, '$author', '$title', '$link')");
    }
        
    /*
     * adds a new comment
     */
    function addComment($bookID, $comment) {
        doSql("INSERT INTO comments VALUES (0, '$bookID', '$comment', '')");
    }
        
    /*
     * removes a book and its associated comments
     * returns true if successful, false if failed
     */
    function removeBook($bookID) {
        $findBooksQuery = doSql("SELECT * FROM books where id='$bookID'");
        if (1 == mysql_num_rows($findBooksQuery)) {
            doSql("DELETE FROM books WHERE id='$bookID';");
            doSql("DELETE FROM comments WHERE bookId='$bookID';");
            return true;
        } else
            return false;
    }
    
    /*
     * returns a single book object, else returns false if no book found
     */
    function retrieveBook($bookID) {
        $book = doSQl("SELECT * FROM books WHERE id=$bookID");
        return (mysql_num_rows($book) == 1)? mysql_fetch_object($book) : false;
    }

    /*
     * returns a resource of books, else returns false if 0 books added
     */
    function retrieveBooks() {
        return doSQl("SELECT * FROM books ORDER BY id DESC");
    }
    
    /*
     * returns a resource of the comments on a book
     */
    function retrieveComments($bookID) {
        return doSQL("SELECT * FROM comments WHERE bookId=$bookID ORDER BY id");
    }
    
    /*
     * returns comment string back if it is valid, else an error message
     */
    function validComment($comment) {
        if (strlen($comment) > MAX_COMMENT)
            return "Comment too long.";
        if (strlen($comment) < 1)
            return "No empty comments allowed.";
        return $comment;
    }
    
    /*
     * returns a single stock comment string given text
     */
    function displayComment($commentText) {
        return "<p class=\"singleComment\">$commentText</p><hr />";
    }
    
    /*
     * returns a resource of books from a list of IDs
     */
    function retrieveBookResource($bookIDs) {
        if (count($bookIDs) > 0) {
            $books = implode(',', $bookIDs);
            return doSql("SELECT * FROM books WHERE id IN ($books) ORDER BY find_in_set(id, '$books') DESC");
        } else
            return doSql("SELECT * FROM books WHERE 1 = 0");
    }
    
    /*
     * displays a single book given its object
     */
    function displayBook($b) {
        echo "<div class='book' data-role='collapsible' ";
        echo "data-collapsed='false' data-theme='e' data-content-theme='c' data-book-id='{$b->id}'>";
        echo "    <h3>{$b->title}</h3>";
        if ($b->imageURL) echo "    <img src='{$b->imageURL}' class='bookImage' alt='{$b->title}' />";
        echo "    <p class='author'>By {$b->author}</p>";
        echo "<a href='#' data-role='button' data-purpose='addToFavorites' data-inline='true' data-theme='b'>Add to Favorites</a>";
        echo "<a href='#' data-role='button' data-purpose='removeFromFavorites' data-inline='true'>Remove from Favorites</a><br />";
        echo "<a href='/dialogue/confirmRemoveFromSuggested.php?bookID={$b->id}' data-role='button' data-purpose='removeFromSuggested' data-rel='dialogue' data-inline='true'>Remove from Suggested</a><br />";
        
        echo "<div data-role='collapsible' class='commentContainer'>";
        echo "    <h3>Comments</h3>";
        echo "    <div class='commentBox'>";
        
        $comments = retrieveComments($b->id);
        while ($c = mysql_fetch_object($comments)) {
            echo displayComment($c->comment);
        }
        
        echo "    </div> <!-- / commentBox -->";
        echo "    <textarea class='newCommentTextArea' placeholder='Maximum of " . MAX_COMMENT . " characters.'></textarea>";
        echo "    <a href='#' data-role='button' data-purpose='addComment' data-inline='true' data-theme='b'>Add Comment</a>";
        echo "</div> <!-- / commentContainer -->";
        
        echo "</div> <!-- / collapsible -->";
    }
    
    /*
     * displays books given a book resource, returns false if empty resource
     */
    function displayBooks($books) {
        if (mysql_num_rows($books) < 1)
            return false;
        else {
            while ($b = mysql_fetch_object($books)) {
                displayBook($b);
            }
            return true;
        }
    }
    
    /*
     * cleans form input
     */
    function clean($input) {
        return mysql_real_escape_string(trim($input));
    }
?>