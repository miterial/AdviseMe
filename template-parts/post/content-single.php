<div class="movie-detail">
      <div class="movie-detail--poster" style="background-image: url('<?php the_field('bg_movie_m') ?>');" ></div>
      <div class="container upper">
        <div class="media mb-3"><img class="movie-detail--info mr-3" src="<?php the_field('poster_m')?>" alt="movie" width="180px"/>
          <div class="media-body align-self-end">
            <h3 class="mt-0"><?php the_title(); ?> (<?php the_field('year_m')?>)</h3>
            <p class="text-muted"><?php the_field('alt-name_m')?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2 col-sm-12 text-center"><a class="inline-block" href="#">Показать трейлер</a></div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-2 col-sm-12 p-0">
            <div class="movies-related">
              <p>Похожие сериалы</p>
              <label><a href="#"><img src="/dist/images/jjposter.jpg" alt="movie image" width="100%"/> Джессика Джонс</a></label>
              <label class="mt-3"><img src="/dist/images/jjposter.jpg" alt="movie image" width="100%"/> Джессика Джонс</label>
              <label class="mt-3"><img src="/dist/images/jjposter.jpg" alt="movie" width="100%"/> Джессика Джонс</label>
              <label class="mt-3"><img src="/dist/images/jjposter.jpg" alt="movie" width="100%"/> Джессика Джонс</label>
              <label class="mt-3"><img src="/dist/images/jjposter.jpg" alt="movie" width="100%"/> Джессика Джонс</label><a href="movies.html">Показать больше</a>
            </div>
          </div>
          <div class="col-lg-10 col-sm-12">
            <div class="movie-info-block">
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