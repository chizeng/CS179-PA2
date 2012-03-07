<?php

    /**
     * addComment.php
     * adds a comment to a book given the ID
     */
        
    // get core functionalities
    require_once('../core.php');
    header('Content-Type: application/json');
    
    // get data
    $bookID = clean($_POST['bookID']);
    $comment = clean($_POST['comment']);
    
    // begin json notation
    echo "{\"valid\": ";
    
    // is comment valid?
    $val = validComment($comment);
    $validCom = (strcmp($val, $comment) == 0);
    $comment = $val;
    echo ($validCom) ? "true" : "false";
    echo ",";
    
    // what is final return message?
    echo "\"text\":";
    if ($validCom) {
        addComment($bookID, $comment);
        echo "\"";
        echo trill(slashdoubles(displayComment($comment)))."\"";
    } else
        echo "\"".trill(slashdoubles("<p class=\"commentError error\">$comment</p>"))."\"";
    
    // end json
    echo '}';
    
?>