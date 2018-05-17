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
      <li class="nav-item"><a class="nav-link" href="collections">Подборки</a></li>
      <li class="nav-item"><a class="nav-link" href="about">О нас</a></li>
      <li class="nav-item">
        <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
      </li>
      <li class="nav-item"><a class="nav-link" href="#">Вход </a></li>
    </ul>
  </div>
</div>
</nav><!-- #site-navigation -->
