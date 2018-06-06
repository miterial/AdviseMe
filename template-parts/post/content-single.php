<?php
// Поставить оценку фильму
  $user = new AM_User();
  $userID = $user->getUserInfoFromDB("id");
  $rate = 0;

  // Оценивал ли пользователь этот фильм
  $conn = db_connect();
  $sqlGetStars = sprintf("SELECT * FROM users_movies WHERE id_user ='%s' AND id_movie ='$s'", $userID, get_field("movie_id_m"));
  $result = $conn->query($sqlGetStars);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rate = $row['rate'];
        $date = $row['date'];
      }
  }
  $conn->close();
  ?>
<div class="movie-detail">
      <div class="movie-detail--poster" style="background-image: url('<?php the_field('bg_movie_m') ?>');" ></div>
      <div class="container upper">
        <div class="media mb-3"><img class="movie-detail--info mr-3" src="<?php the_field('poster_m')?>" alt="movie" width="180px"/>
          <div class="media-body align-self-end">
            <h2 class="mt-0"><?php the_title(); ?> (<?php the_field('year_m')?>)</h2>
            <p class="text-muted"><?php the_field('alt-name_m')?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2 col-sm-12 text-center"><a class="inline-block" href="#">Показать трейлер</a></div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-2 col-sm-12 p-0">
            <div class="movies-related">
              <p>Похожие фильмы</p>
              <label><a href="#"><img src="/dist/images/jjposter.jpg" alt="movie image" width="100%"/> Джессика Джонс</a></label>
             <a href="movies.html">Показать больше</a>
            </div>
          </div>
          <div class="col-lg-10 col-sm-12">
            <div class="movie-info-block">
              <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="rate_form">
              <div class="stars">
                <p>Моя оценка: </p>
                <select id="movieRatingSelect" name = "movieRatingSelect">
                  <option value="" name="movieRating1"></option>
                  <option value="1" name="movieRating2">1</option>
                  <option value="2" name="movieRating3">2</option>
                  <option value="3" name="movieRating4">3</option>
                  <option value="4" name="movieRating5">4</option>
                  <option value="5" name="movieRating6">5</option>
                  <option value="6" name="movieRating7">6</option>
                  <option value="7" name="movieRating8">7</option>
                  <option value="8" name="movieRating9">8</option>
                  <option value="9" name="movieRating10">9</option>
                  <option value="10" name="movieRating11">10</option>
                </select>
                <input type="hidden" name="action" value="rateMovie">
                <p class="d-none" id="myRate"><?php echo $rate; ?></p>
                <p class="valToInsert d-none" id="movieID"><?php the_field('movie_id_m'); ?></p>
                <div id="output"></div>
              </div>
              </form>
              
                
            <p class="d-inline">AdviseMe: </p>
            <p class="d-inline font-weight-bold" id="rateAM"><?php the_field('am_score') ?></p>
            <p class="d-inline">IMDB: </p>
            <p class="d-inline font-weight-bold" id="rateIMDB"><?php the_field('imdb_score') ?></p>
            <p class="d-inline">Кинопоиск: </p>
            <p class="d-inline font-weight-bold" id="rateKP"><?php the_field('kp_score') ?></p>
            <p class="font-weight-bold mt-3">Жанр: 
            <?php
              $genres = get_field('genres_m');
              if($genres)
                foreach($genres as $g) { ?>
                  <a class="movie-detail--list" href="#"> <?php echo $g; ?></a>
              <?php  }
              ?>
            </p>
            <p class="font-weight-bold">Страна: 
            <?php
              $countries = get_field('countries_m');
              if($countries)
                foreach($countries as $c) { ?>
                  <a class="movie-detail--list" href="#"> <?php echo $c; ?></a>
              <?php  }
              ?>
            </p>
            <p class="d-inline font-weight-bold">Премьера: </p>
            <p class="d-inline"><?php the_field('premiere_m'); ?></p>
            <p class="mt-3"><?php the_field('description_m'); ?></p>
            <p class="movie-makers">Режиссёры</p>
            <?php
              $dirs = get_field('director_m');
              if($dirs)
                foreach($dirs as $d) { ?>
                  <a href="#"> <?php echo $d; ?></a>
              <?php  }
              ?>
            <p class="movie-makers mt-3">В ролях</p>
            <?php
              $actors = get_field('actors_m');
              if($actors)
                foreach($actors as $a) { ?>
                  <a href="#"> <?php echo $a; ?></a>
              <?php  }
              ?>
            <p class="movie-makers mt-3">Отзывы пользователей</p>
              <?php comments_template(); ?>
                
              </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
   $(document).ready(function() {
    var rateTag = $('#myRate').innerHTML;
    if(rateTag != "0") {
      $('#movieRatingSelect').barrating('set', rateTag);
    }
      $('#movieRatingSelect').barrating({
        theme: 'fontawesome-stars',
        onSelect: function(value, text, event) {
            event.preventDefault();
          if (typeof(event) !== 'undefined') {
            var filter = $('#rate_form');
            $("#myRate").innerHTML = value;

            $("#rate_form .valToInsert").each(function(i,v){
                  $("#rate_form").append(
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
   });
</script>
