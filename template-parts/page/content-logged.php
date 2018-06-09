
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
                  <div class="text-center">
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
          <?php $posts = get_posts(array('numberposts' => 15));
            foreach($posts as $post){ setup_postdata($post); ?>
                <div class="slider-item col-md-3"><a href="<?php the_permalink() ?>"><img src="<?php echo get_field('poster_m'); ?>" alt="movie" width="150px"/></a>
                  <div class="text-center">
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
                <?php $posts = get_posts(array('numberposts' => 15));
            foreach($posts as $post){ setup_postdata($post); ?>
                <div class="slider-item col-md-3"><a href="<?php the_permalink() ?>"><img src="<?php echo get_field('poster_m'); ?>" alt="movie" width="150px"/></a>
                  <div class="text-center">
                    <p><?php the_title(); ?></p>
                  </div>
                </div>
           <?php }
            wp_reset_postdata();
            ?>
          </div>
        </section>
      </div>
      <div class="col-lg-3"><a class="text-nowrap show-more" href="#">Показать больше <i class="fa fa-long-arrow-right"></i></a></div>
    </div>
  </div>
</div>
<div class="collections">
  <div class="container">
    <div class="row"></div>
  </div>
</div>
