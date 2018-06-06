 <?php 
 	/*
    Template Name: Фильтр
    */
 get_header(); ?> 
<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter_form">
<div class="filter">
      <h1 class="text-center py-3">НАЙТИ ФИЛЬМ</h1>
      <div class="filter--settings">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-xs-12">
              <div class="sliders" id="regular-slider"></div>
              <span class="d-none yearVal" id="min-year"></span>
              <span class="d-none yearVal" id="max-year"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-s-12">
              <h2>Жанры</h2>
              <ul class="toggles">
                <?php
                  $conn = db_connect();
                  if($conn != null) {
                    $genresToPrint = get_genres($conn); 
                    for($i = 0; $i < count($genresToPrint); $i++) { ?>
                    <li>
                      <input class="genreToggle tgl-skewed" type="checkbox" name="genreToggle[]" id="genreToggle_<?php echo $i ?>" value="<?php echo $genresToPrint[$i] ?>" data-toggle="toggle"/>
                      <label class="tgl-btn" for="genreToggle_<?php echo $i ?>"><?php echo $genresToPrint[$i] ?></label>
                    </li>
                    
                    <?php }
                    //Добавление постов
                    //$movie = get_movies_full($conn, true); 
                  
                ?>
              </ul>
              <h2>Страны</h2>
              <ul class="toggles toggles__long" style="overflow: hidden;">
                <?php
                    $genresToPrint = get_countries($conn); 
                    for($i = 0; $i < count($genresToPrint); $i++) { ?>
                    <li>
                      <input class="countryToggle tgl-skewed" type="checkbox" name="countryToggle[]" id="countryToggle_<?php echo $i ?>" value="<?php echo  $genresToPrint[$i] ?>" data-toggle="toggle"/>
                      <label class="tgl-btn" for="countryToggle_<?php echo $i ?>"><?php echo $genresToPrint[$i] ?></label>
                    </li>
                    
                    <?php }
                    $conn->close();
                  }
                ?>
              </ul>
              <button id="show_more">Показать больше</button>
            </div>
            <div class="col-lg-6 col-xs-12">
              <h2>Минимальная оценка</h2>
              <div class="row">
                <div class="col-lg-3 col-sm-2">
                  <p>IMDB</p>
                </div>
                <div class="col-lg-8 col-sm-9">
                  <div class="sliders" id="rate-slider1"></div>
                </div>
                <div class="col-lg-1 col-sm-1">
                  <p id="rate-text1">0.0</p>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-md-2 col-sm-3">
                  <p>Кинопоиск</p>
                </div>
                <div class="col-lg-8 col-md-9 col-sm-7">
                  <div class="sliders" id="rate-slider2"></div>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-2">
                  <p id="rate-text2">0.0</p>  
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-sm-2">
                  <p>AdviseMe</p>
                </div>
                <div class="col-lg-8 col-sm-9">
                  <div class="sliders" id="rate-slider3"></div>
                </div>
                <div class="col-lg-1 col-sm-1">
                  <p id="rate-text3">0.0</p>
                </div>
              </div>
              <div class="row">
                <div class="col-auto">
                  <button class="light-button">Сбросить фильтр</button>
                </div>
                <div class="col-auto">
                  <button id="submit" type="submit" value="Submit" class="light-button">Начать поиск</button>
                  <input type="hidden" name="action" value="myfilter">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h1 class="text-center py-3">Рекомендуемые фильмы</h1>
    <div class="filtered-movies container">
        <div id="filterRes">
      <?php
      $cur_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
              $params = array(
                'posts_per_page' => 18, // количество постов на странице
                'paged'          => $cur_page,
              );
              query_posts($params);
           
          $wp_query->is_archive = true;
          $wp_query->is_home = false;
          if ( have_posts() ) : ?>
            <?php

            while ( have_posts() ) : the_post(); ?>

              <div class="filtered-movies--item">
                <a href="<?php the_permalink(); ?>">
                  <img src="<?php the_field('poster_m'); ?>" alt="movie" width="150px" style='height: 210px'/>
                  <?php the_title()?>
                </a>
              </div>

            <?php endwhile; ?>
          <?php 

            the_posts_pagination( array(
              'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
              'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
              'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
            ) );

          else :

            get_template_part( 'template-parts/post/content', 'none' );

          endif; ?></div>
      </div>
    </div>
  </form>

<?php get_footer(); ?>
