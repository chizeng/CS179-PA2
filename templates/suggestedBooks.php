<?php require_once('blocks/header.php'); ?>
    <div data-role="content" id="suggestedBookList">
        <input type="text" placeholder="Filter/search books." id="filterInput" />
        <?php 
            if (array_key_exists("message", $data))
                echo "<p class='message'>{$data['message']}</p>";
            if (!displayBooks(retrieveBooks()))
                echo "<p class='message'>No books added.</p>"; 
            if (array_key_exists('bookRemovedID', $data))
                echo "<script type='text/javascript'>\$(function(){\$('[data-book-id=".$data["bookRemovedID"]."]').remove();});</script>";
        ?>
    </div><!-- /content -->
<?php require_once('blocks/footer.php'); ?>
