<?php 
function my_comments( $comment, $args, $depth ) {
	global $post;
	$author_id = $post->post_author;
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments. ?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e( 'Pingback:', 'twenties' ); ?></span> <?php comment_author_link(); ?></div>
	<?php
		break;
		default :
		// Proceed with normal comments. ?>
	<li id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" <?php comment_class('clr'); ?>>
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 45 ); ?>
			</div><!-- .comment-author -->
			<div class="comment-details clr">
				<header class="comment-meta">
					<p class="fn"><?php comment_author_link(); ?></p>
					<p class="fn"><?php /*comment_movie_rate();*/ ?></p>
					<span class="comment-date">
					<?php printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( _x( '%1$s', '1: date', 'twenties' ), get_comment_date() )
					); ?> <?php esc_html_e( 'в', 'twenties' ); ?> <?php comment_time(); ?>
					</span><!-- .comment-date -->
				</header><!-- .comment-meta -->
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'twenties' ); ?></p>
				<?php endif; ?>
				<div class="comment-content entry clr">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->
			</div><!-- .comment-details -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // End comment_type check.
}

function comment_movie_rate() {
	$conn = db_connect();
        if($conn != null) {
        	$movieID = get_field('movie_id_m');
        	$sqlPosts = 'SELECT am_score FROM movies WHERE id = $movieID';
    		$resultPosts = $connection->query($sqlPosts);
		    if ($resultPosts->num_rows > 0) {
		      while($row = $resultPosts->fetch_assoc()) {
		      	$titlesArr[] = $row["am_score"];
		      }
		      }
        }
}

function all_comments_user(){
global $wpdb;
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
$author_lk = $curauth->ID;
$inpage = 5;
 
	if($_GET['navi']) $navi = $_GET['navi'];
		else $navi=1;
 
	$start = ($navi-1)*$inpage;
 
	$count_comments = $wpdb->get_var("SELECT COUNT(comment_ID) FROM ".$wpdb->prefix ."comments WHERE user_id = '$author_lk'");
	$comments_user = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."comments WHERE user_id = '$author_lk' ORDER BY comment_date DESC LIMIT $start,$inpage");
 
	$num_page = ceil($count_comments/$inpage);
 
	if($comments_user){
		$commentlist = '<div id="commentlist">';
		$commentlist .= '<h3 class="mb-3">Комментарии пользователя</h3>';	
		foreach($comments_user as $comment){			
			$commentlist .= '<div id="feed-comment-'.$comment->comment_post_ID.'" class="feedcomment">';					
			$commentlist .= '<h3 class="feed-title">к фильму <a href="'.get_permalink( $comment->comment_post_ID ).'">'.get_the_title($comment->comment_post_ID).'</a></h2>
				<small>'.mysql2date('j F Y G:i:s', $comment->comment_date).'</small>';				
			$commentlist .= '<div class="feed-content">'.$comment->comment_content.'</div>';	
			$commentlist .= '</div>';
		}	
		$commentlist .= '</div>';
		echo $commentlist;
		if($inpage&&$count_comments>$inpage){
			$url = get_author_posts_url($author_lk);
			$url = explode('?',$url);
			if($url[1]){ 
				$redirect_url = get_author_posts_url($author_lk).'&';
			}else{
				$redirect_url = get_author_posts_url($author_lk).'?';
			}
			$page_navi .= '<div class="user-navi">';
			$next = $navi + 3;
			$prev = $navi - 4;
			if($prev==1) $page_navi .= '<a href="'.$redirect_url.'navi=1">1</a>';
			for($a=1;$a<=$num_page;$a++){
			if($a==1&&$a<=$prev&&$prev!=1) $page_navi .= '<a href="'.$redirect_url.'navi=1">1</a> ... ';			
				if($prev<$a&&$a<=$next){
				if($navi==$a) $page_navi .= '<span>'.$a.'</span>';
					else $page_navi .= '<a href="'.$redirect_url.'navi='.$a.'">'.$a.'</a>';
				}				
			}
			if($next<$num_page&&$num_page!=$next+1) $page_navi .= ' ... <a href="'.$redirect_url.'navi='.$num_page.'">'.$num_page.'</a>';
			if($num_page==$next+1) $page_navi .= '<a href="'.$redirect_url.'navi='.$num_page.'">'.$num_page.'</a>';
			$page_navi .= '</div>';
		}
 
		echo $page_navi;
	}
}
?>