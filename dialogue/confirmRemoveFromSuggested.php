<?php

/*
 * removes a book from the suggested list 
 * for Ben B.'s book club after dialogue confirmation
 *
 * By Chi Zeng, CS179, Spring 2012
 *
 */
    
    // get core functionality
    require_once('../core.php');
    
    // get book object
    $bookID = clean($_GET['bookID']);
    $book = retrieveBook($bookID);
    
?>

<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>jQuery Mobile Framework - Dialog Example</title> 
<link rel="stylesheet"  href="http://jquerymobile.com/test/css/themes/default/jquery.mobile.css" />  
<link rel="stylesheet" href="http://jquerymobile.com/test/docs/_assets/css/jqm-docs.css"/>

<script src="http://jquerymobile.com/test/js/jquery.js"></script>
<script src="http://jquerymobile.com/test/docs/_assets/js/jqm-docs.js"></script>
<script src="http://jquerymobile.com/test/js/jquery.mobile.js"></script>

</head> 
<body> 

<div data-role="page">
<div data-role="header" data-theme="e">

</div>

<div data-role="content" data-theme="e">
<p> Remove <u><?= $book->title ?></u> from the suggested reading list? Its comments will be deleted too.</p>
<a href="/suggestedBooks.php?bookIDToRemove=<?= $book->id ?>" data-role="button" data-theme="a">Yes, remove it</a>       
<a href="#" data-role="button" data-rel="back" data-theme="c">No, keep it.</a>    
</div>
</div>


</body>
</html>