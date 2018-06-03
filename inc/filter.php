<?php
	/*echo 'filtered_movies ENTERED ' . '</br>';
	$myGenres = $_POST['genres'];
	$myCountries = $_POST['countries'];

	$args = array(
		'numberposts'	=> -1,
		'meta_query'	=> array(
			'relation'	  => 'OR' )
	);

	if(isset( $_POST['genres'] ) )
		for($i = 0; $i < count($myGenres); $i++) {
			$args['meta_query'][] = array(
				'key' => 'genres_m',
				'value'		=> '"'.$myGenres[$i].'"',
				'compare'	=> 'LIKE'
			);
		}

	if(isset( $_POST['countries'] ) )
		for($i = 0; $i < count($myCountries); $i++) {
			$args['meta_query'][] = array(
				'key' => 'genres_m',
				'value'		=> '"'.$myGenres[$i].'"',
				'compare'	=> 'LIKE'
			);
		}

	// query
	$the_query = new WP_Query( $args );

	?>
	<?php if( $the_query->have_posts() ): ?>
		<ul>
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<div class="filtered-movies--item">
				<a href="<?php the_permalink(); ?>">
				  <img src="<?php the_field('poster_m'); ?>" alt="movie" width="150px" style='height: 210px'/>
				  <?php the_title()?>
				</a>
			</div>
		<?php endwhile; ?>
		</ul>
	<?php endif; ?>

	<?php wp_reset_query();	 // Restore global post data stomped by the_post(). */