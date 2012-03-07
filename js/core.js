/*
 * contains core functionality such as ajax
 * for Ben B.'s book club
 *
 * By Chi Zeng, CS179, Spring 2012
 *
 */

// an array storing IDs of favorite books
var favorites = [];

// adds a book to favorites
function addToFavorites(bookID) {
    if ($.inArray(bookID, favorites) != -1)
        return;
    favorites.push(bookID);
    localStorage.setItem('favorites', JSON.stringify(favorites));
    return;
}

// get initial favorites if localStorage exists
function getFavorites() {
    if (localStorage)
        if (localStorage.getItem('favorites'))
            return JSON.parse(localStorage.getItem('favorites'));
    return [];
}

// removes a book from favorites
function removeFromFavorites(bookID) {
    if ($.inArray(bookID, favorites) == -1)
        return;
    favorites.splice(favorites.indexOf(bookID), 1);
    localStorage.setItem('favorites', JSON.stringify(favorites));
    return;
}

// update button displays
function updateButtonDisplay() {
    $('[data-purpose="addToFavorites"]').each(function() {
                                              var bookID = $(this).closest('.book').attr('data-book-id');
                                              $(this).click(function() {
                                                  addToFavorites(bookID);
                                              });
                                              if ($.inArray(bookID, favorites) != -1)
                                                  $(this).hide();
                                              else
                                                  $(this).show();

    });
    
    $('[data-purpose="removeFromFavorites"]').each(function() {
                                              var bookID = $(this).closest('.book').attr('data-book-id');
                                              if ($.inArray(bookID, favorites) != -1)
                                                   $(this).show();
                                              else
                                                   $(this).hide();
                                              });
    console.log(JSON.stringify(localStorage.getItem('favorites')));
}

// adds a comment to a book.
function addComment(bookID) {
    var comment;
    var commentTextArea;
    
    commentTextArea = $("[data-book-id='" + bookID + "'] .newCommentTextArea");

    $.ajax({
       cache: false,
       url: "ajax/addComment.php",
       type: 'POST',
       dataType: 'json',
       data: {'bookID': bookID, 'comment': commentTextArea.val()},
       context: $('[data-book-id=' + bookID + '] .commentBox'),
       success: function(data){
           if (data.valid)
               $(this).append(data.text);
           else {
               $('.commentError').hide();
               $("[data-book-id='" + bookID + "'] .commentBox").append(data.text);
           }
       },
       error: function (jqXHR, textStatus, errorThrown) {
           console.log("Error:" + textStatus + ", text: " + jqXHR.responseText + errorThrown);
       }
    });
}

// bind events to buttons
function buttonEvents() {
    $('[data-purpose="addToFavorites"]').click(function() {
                                               var bookID = $(this).closest('.book').attr('data-book-id');
                                               addToFavorites(bookID);
                                               updateButtonDisplay();
                                               });
    
    $('[data-purpose="removeFromFavorites"]').click(function() {
                                                    var bookID = $(this).closest('.book').attr('data-book-id');
                                                    removeFromFavorites(bookID);
                                                    updateButtonDisplay();
                                                    });
    
    $("[data-purpose='addComment']").click(function () {
                                           var bookID = $(this).closest(".book").attr('data-book-id');
                                           addComment(bookID);
                                           });
}

// searches books by keyword
function search(keyword) {
    if (keyword.length > 0) {
        $("#suggestedBookList .book").hide();
        $("#suggestedBookList .book:contains(" + keyword + ")").show();
    } else
        $("#suggestedBookList .book").show();
}

// page load event for mobile
$('[data-role=page]').live('pageshow', function (event) {
                           favorites = getFavorites();
                           updateButtonDisplay();
                           buttonEvents();
                           
                           // make search case insensitive
                           $.expr[':'].contains = function(a, i, m) {
                              return ($(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0);
                           };

                           $('input#filterInput').keyup(function() {
                                                    search($(this).val());
                                });
                           
                           
                           // disable caching
                           $('div').live('pagehide', function(event, ui){
                                              var page = $(event.target);
                                              
                                              if(page.attr('data-cache') == 'never'){
                                                    page.remove();
                                                };
                                              });
                           });
