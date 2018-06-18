<?php

set_time_limit(0);
ini_set('mysql.connect_timeout', 600);
ini_set('default_socket_timeout', 600);
ini_set('max_allowed_packet', 524288000);
// ?fill_db=3000&cats=1|3&tags=tag1|tag2|tag3
// ?fill_db_comments=3000

function fill_db(array $iddd, array $titleee, array $alttitle, array $date, array $overview, array $posterrr, array $bg, array $am, array $kp, array $imdb, array $genres,array $countries, array $dirs, array $acts, $insert) {

	$movieTitle = $titleee;
	$movieID = $iddd;
	$moviePoster = $posterrr;
	$movieAltTitle = $alttitle;
	$movieDate = $date;
	$movieOverview = $overview;
	$moviePoster = $posterrr;
	$movieBG = $bg;
	$movieAMScore = $am;
	$movieKPScore = $kp;
	$movieIMDBScore = $imdb;

    echo 'Enter fill_db' . '</br>';
	wp_suspend_cache_addition( true ); // отключаем кэширование

	// Контент
		$limit = count($movieID);

if($insert) {
		//запускаем цикл
		for( $i = 0; $i < $limit; $i++ ){

			//добавление в БД wordpress
			$postid = wp_insert_post( array(
				'post_title'     => $movieTitle[$i],
				'post_status'    => 'publish',
			) );

			if( $postid ){

                  echo 'PostSuccess ' . $postid . '</br>';
					fill_db_with_metadata_add_views( $postid, $movieID[$i], $movieTitle[$i], $movieAltTitle[$i], $movieDate[$i], $movieOverview[$i], $moviePoster[$i], $movieBG[$i], $movieAMScore[$i], $movieKPScore[$i], $movieIMDBScore[$i], $genres[$i], $countries[$i], $dirs[$i], $acts[$i]);
			}
			//else echo "error";
			flush();
		}
}

		//изменение полей
		$args = array(
			'numberposts' => -1,
			'order' => 'ASC',
		);
		$posts = get_posts( $args );
		$i = 0;

		foreach( $posts as $post ){
			echo 'PostUpdateSuccess ' . $post->ID . '</br>';
			update_my_acf_fields( $post->ID, $movieAMScore[$i], $movieKPScore[$i], $movieIMDBScore[$i], $genres[$i], $countries[$i], $dirs[$i], $acts[$i]);

			flush();
			$i++;
		}

		wp_reset_postdata(); // сброс
}


function update_my_acf_fields($post_id, $amm, $kpp, $imdbb, $ggen, $ccontr, $ddirs, $aacts) {
	echo $post_id . '_'. $amm .'_' . $kpp . '_' . $imdbb .'_'. $ggen .'_'. $ccontr.'_'. $ddirs .'_'. $aacts . '</br>';
	$value[] = $amm;
	$value[] = $kpp;
	$value[] = $imdbb;

	$value[] = $ggen;
	$value[] = $ccontr;
	$value[] = $ddirs;
	$value[] = $aacts;

	$i=0;

	update_post_meta( $post_id, 'am_score', $value[$i++] );
	update_post_meta( $post_id, 'kp_score', $value[$i++] );
	update_post_meta( $post_id, 'imdb_score', $value[$i++] );

	//информация из таблиц-связей
	update_post_meta( $post_id, 'genres_m', $value[$i++] );
	update_post_meta( $post_id, 'countries_m', $value[$i++] );
	update_post_meta( $post_id, 'director_m', $value[$i++] );
	update_post_meta( $post_id, 'actors_m', $value[$i++] );
}

// Добавляем произвольное поле к создаваемым постам
function fill_db_with_metadata_add_views( $post_id, $movie_id, $movie_title,$alt_title, $date, $over, $poster, $bgg, $amm, $kpp, $imdbb, $ggen, $ccontr, $ddirs, $aacts){
	
	$value[] = $movie_title;
	$value[] = $alt_title;
	$value[] = $date;
	$value[] = date("Y", strtotime($date));
	$value[] = $over;
	$value[] = $poster;
	$value[] = $bgg;
	$value[] = $movie_id;
	$value[] = $amm;
	$value[] = $kpp;
	$value[] = $imdbb;

	$value[] = $ggen;
	$value[] = $ccontr;
	$value[] = $ddirs;
	$value[] = $aacts;
	$i = 0;
	//информация из таблицы movies
	update_post_meta( $post_id, 'name_m', $value[$i++] );
	update_post_meta( $post_id, 'alt_name_m', $value[$i++] );
	update_post_meta( $post_id, 'premiere_m', $value[$i++] );
	update_post_meta( $post_id, 'year_m', $value[$i++] );
	update_post_meta( $post_id, 'description_m', $value[$i++] );
	update_post_meta( $post_id, 'poster_m', $value[$i++] );
	update_post_meta( $post_id, 'bg_movie_m', $value[$i++] );
	update_post_meta( $post_id, 'movie_id_m', $value[$i++] );
	update_post_meta( $post_id, 'am_score', $value[$i++] );
	update_post_meta( $post_id, 'kp_score', $value[$i++] );
	update_post_meta( $post_id, 'imdb_score', $value[$i++] );

	//информация из таблиц-связей
	update_post_meta( $post_id, 'genres_m', $value[$i++] );
	update_post_meta( $post_id, 'countries_m', $value[$i++] );
	update_post_meta( $post_id, 'director_m', $value[$i++] );
	update_post_meta( $post_id, 'actors_m', $value[$i++] );
}
