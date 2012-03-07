<?php require_once('blocks/header.php'); ?>
<script type="text/javascript">
// page load event for mobile
$('[data-role=page]:has(#favoritesList)').live('pageshow', function (event) {
                                $.ajax({
                                       cache: false,
                                  type: 'POST',
                                  url: "ajax/listBooks.php",
                                  context: $('#favoritesList[data-role="content"]'),
                                  data: {books: JSON.stringify(favorites)},
                                  success: function(data) {
                                       console.log(data);
                                       console.log(JSON.stringify(localStorage.getItem('favorites')));
                                  if (true) {
                                      $(this).html(data).trigger("create");
                                      var newFavorites = [];
                                      $('.book').each(function() {
                                                      newFavorites.push($(this).attr('data-book-id'));
                                                      });
                                      localStorage.setItem('favorites', JSON.stringify(newFavorites));
                                      $('#favoritesList [data-purpose="removeFromSuggested"]').hide();
                                       } else {
                                       $(this).html("You have no favorite books.").trigger("create");
                                       }
                                       updateButtonDisplay();
                                       buttonEvents();
                                  }
                               });
                           });
</script>
    <div data-role="content" id="favoritesList">
        
    </div><!-- /content -->
<?php require_once('blocks/footer.php'); ?>
