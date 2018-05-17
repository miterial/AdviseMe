<?php
/**
 * Переход по страницам
*/
function my_pagination() {
	if ( is_singular() ) {
		return;
	}

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**    Add current page to the array */
	if ( $paged >= 1 ) {
		$links[] = $paged;
	}

	/**    Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="pagination d-flex justify-content-center" aria-label="Page navigation"><ul class="d-flex">' . "\n";
 
		/**    Previous Post Link */
		if ( get_previous_posts_link() ) {
			printf( // WPCS: XSS OK.
				'<li class="mr-auto"><span class="pagi-arrow">%1$s</span></li> ' . "\n",
			get_previous_posts_link(  // WPCS: XSS OK.
			 '<span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> Предыдущая
          </span>' ) );
		}
		else {
			echo '<li class="col-md-5"></li>';
		}

		if ( ! in_array( 2, $links ) ) {
			echo '<li class="d-none d-sm-block"></li>';
		}

	// Link to current page, plus 2 pages in either direction if necessary.
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active d-none d-sm-block"' : ' class="d-none d-sm-block"';
		printf( // WPCS: XSS OK.
			'<li %s><a href="%s" class="pagi-number">%s</a></li>' . "\n",
			$class,
			esc_url( get_pagenum_link( $link ) ), $link );
	}

	// Next Post Link.
	if ( get_next_posts_link() ) {
		printf( // WPCS: XSS OK.
			'<li class="ml-auto"><span class="pagi-arrow">%s</span></li>' . "\n",
			get_next_posts_link( '<span aria-hidden="true"><i class="fa fa-long-arrow-right"></i> Следующая </span>' ) );
	}


	echo '</ul></div>' . "\n";
}