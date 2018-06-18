<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
<nav class="navbar navbar-light navbar-expand-lg">
<div class="container">
  <div class="navbar-header logo"><h1><a class="navbar-brand title" href="<?php echo esc_url( home_url( '/' ) ); ?>">AdviseMe</a></h1></div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainnavbar" aria-controls="mainnavbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse mr-auto flex-row-reverse" id="mainnavbar">
    <ul class="navbar-nav navbar-right">
      <li class="nav-item"><a class="nav-link" href="movies">Фильмы</a></li>
      <li class="nav-item"><a class="nav-link" href="about">О нас</a></li>
      <li class="nav-item">
        <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
      </li>
      <?php if(!is_user_logged_in()) : ?>
        <li class="nav-item"><button class="nav-link" id="regBtn">Регистрация </button></li>
        <li class="nav-item"><button class="nav-link" id="authBtn">Вход </button></li>
        <?php else : ?>
          
        <li class="nav-item"><a class="nav-link" id="profileBtn" href="<?php bloginfo('url'); ?>/?author=<?php echo get_current_user_id(); ?>">Профиль </a></li>
      <?php endif;?>
      <li class="nav-item">
      </li>
    </ul>
  </div>
</div>
</nav><!-- #site-navigation -->

<div id="modal-registration">
  <div class="modal-registration-content">
    <span class="close">&times;</span>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('account') ) : ?>
                            <?php endif; ?>
    <?php /*custom_registration_function()*/ ?>
  </div>
</div>

<div id="modal-login">
  <div class="modal-registration-content">
    <span class="close">&times;</span>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('auth') ) : ?>
                            <?php endif; ?>
    <?php /*custom_registration_function()*/ ?>
  </div>
</div>
