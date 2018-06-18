
<div class="movieslists">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <input class="tab-style" id="tab1" type="radio" name="tabs[]" checked />
        <label for="tab1">Новые фильмы</label>
        <input class="tab-style" id="tab2" type="radio" name="tabs[]"/>
        <label for="tab2">Популярные фильмы</label>
        <input class="tab-style" id="tab3" type="radio" name="tabs[]"/>
        <label for="tab3">Рекомендации</label>
        <section id="content1">
          <div class="myslider">
            <?php $posts = get_posts(array('numberposts' => 15));
            foreach($posts as $post){ setup_postdata($post); ?>
                <div class="slider-item"><a href="<?php the_permalink() ?>"><img src="<?php echo get_field('poster_m'); ?>" alt="movie" width="150px"/></a>
                  <div class="">
                    <p><?php the_title(); ?></p>
                  </div>
                </div>
           <?php }
            wp_reset_postdata();
            ?>
          </div>
        </section>
        <section id="content2">
          <div class="myslider">
          <?php $args = array(
                'meta_key' => 'am_score', // ключ поля ACF
                'orderby' => 'meta_value',
                'showposts' => '5', // кол-во выводимых записей
                'order' => 'DESC' // Порядок сортировки записей
                );
           $posts = get_posts($args);
            foreach($posts as $post){ setup_postdata($post); ?>
                <div class="slider-item col-md-3"><a href="<?php the_permalink() ?>"><img src="<?php echo get_field('poster_m'); ?>" alt="movie" width="150px"/></a>
                  <div class="">
                    <p><?php the_title(); ?></p>
                  </div>
                </div>
           <?php }
            wp_reset_postdata();
            ?>
          </div>
        </section>
        <section id="content3">
          <div class="myslider">
          <?php
          $user = new AM_User();
          $idUser = $user->getUserInfoFromDB("id");
           $m = new Recommendation();
          //$m->fillTable();
          $userMovies = $m->getUserRecommendations($idUser);
          if(count($userMovies) > 0) {

          $connection = db_connect();
          for($i = 0; $i < 15; $i++) {
            $sqlMovieName = sprintf("SELECT * FROM movies WHERE id ='%d'", $userMovies[$i]->getMovieID());
            $result = $connection->query($sqlMovieName);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $idPost = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_title = %s", $row['title']));
                  if($idPost) { 
                    //echo "postID: ".$idPost.'</br>';
                    $userMovies[$i]->setPostId($idPost);
                  }
                }
              }
            }
            $connection->close();
            for($i = 0; $i < 15; $i++) {
              echo '<div class="slider-item col-md-3"><a href="'.$userMovies[$i]->getMovieLink().'"><img src="'.$userMovies[$i]->getMovieImage($userMovies[$i]->getMovieID()) .'" alt="movie" width="150px"/></a><div class=""><p>'.$userMovies[$i]->getMovieTitle().'</p></div></div>';
               
            }
           }
           else echo "<h3>Нет рекомендованных фильмов</h3>";
            wp_reset_postdata();
            ?>
          </div>
        </section>
      </div>
      <div class="col-lg-3"><a class="text-nowrap show-more" href="/movies">Показать больше <i class="fa fa-long-arrow-right"></i></a></div>
    </div>
  </div>
</div>
<div class="collections">
  <div class="container">
    <div class="row"></div>
  </div>
</div>
