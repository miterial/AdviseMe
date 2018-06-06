$(document).ready(function() {
    /* Рейтинг фильма */
    var rateTag = $('#myRate').innerHTML;
    if(rateTag != "0") {
        /* Отобразить значение, поставленное ранее */
      $('#movieRatingSelect').barrating('set', rateTag);
    }
      $('#movieRatingSelect').barrating({
        theme: 'fontawesome-stars',
        onSelect: function(value, text, event) {
            event.preventDefault();
          if (typeof(event) !== 'undefined') {
            var filter = $('#rate_form');
            $("#myRate").innerHTML = value;
            /* Подготовка всех данных */
            $("#rate_form .valToInsert").each(function(i,v){
                  $("#rate_form").append(
                      $("<input type='hidden' />").attr({
                          name: $(this).attr('id'),
                          value: $(this).text()
                      })
                  )

              });
        /* При выборе оценки - запись в бд */
            $.ajax({
              url:filter.attr('action'),
              data:filter.serialize(),
              type:filter.attr('method'),
                 success: function(data){  
                  $("#output").html(data);              
                    console.log('success');
                 },
                error: function(jqXHR, textStatus, errorThrown) {
                        console.log('error: ' + errorThrown);
                    },
            });

          } else {
            // rating was selected programmatically
            // by calling `set` method
          }
        }
      });

      /* Добавление фильма в список нежелательных */
      $('#dislikeBtn').on('click', function(e) {
            e.preventDefault();
            var filter = $('#dislike_form');
            /* Подготовка всех данных */
            $("#dislike_form .valToInsert").each(function(i,v){
                  filter.append(
                      $("<input type='hidden' />").attr({
                          name: $(this).attr('id'),
                          value: $(this).text()
                      })
                  )

              });
        $.ajax({
              url:filter.attr('action'),
              data:filter.serialize(),
              type:filter.attr('method'),
                 success: function(data){              
                    console.log('successfully disliked');
                 },
                error: function(jqXHR, textStatus, errorThrown) {
                        console.log('error: ' + jqXHR);
                    },
            });
      }
      );
   });
