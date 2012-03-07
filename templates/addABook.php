<?php require_once('blocks/header.php'); ?>
    
    <script type="text/javascript">
        // load any form errors if there are any
        $('[data-role=page]').live('pageshow', function (event) {
            <?php
              echo "\$('.formError').remove();";
              foreach ($formErrors as $field => $error) {
                  echo "\$(\"label[for='$field']\").append('<p class=\"formError\">$error</p>').trigger('create');";
              }
            ?>
        });
    </script>

    <div data-role="content">

        <form action="addABook.php" method="post">
            <div data-role="fieldcontain">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?= $bookTitle ?>" placeholder="Max. <?= MAX_BOOK_TITLE ?> characters." />
            </div>
            <div data-role="fieldcontain">
                <label for="author">Author's Full Name:</label>
                <input type="text" name="author" id="author" value="<?= $bookAuthor ?>" placeholder="Max. <?= MAX_BOOK_AUTHOR ?> characters." />
            </div>
            <div data-role="fieldcontain">
                <label for="url">Cover Image URL:</label>
                <input type="url" name="url" id="url" value="<?= $bookURL ?>" placeholder="Max. <?= MAX_BOOK_URL ?> characters." />
            </div>
            <input type="submit" value="Add Book" />
        </form>
    </div><!-- /content -->
<?php require_once('blocks/footer.php'); ?>
