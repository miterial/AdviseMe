<?php get_header(); ?>
<?php
 if(!is_user_logged_in()) :
  get_template_part( 'template-parts/page/content', 'not_registered'); 
else : 
  get_template_part( 'template-parts/page/content', 'logged'); 
endif;
?>


<?php get_footer();
