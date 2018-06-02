<?php get_header(); ?>

<?php
// Установка переменной текущего автора $curauth
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>

<div id="w">
    <div id="content" class="clearfix">
      <div id="userphoto"><?php echo get_avatar( $curauth->user_email, '90 '); ?></div>
      <h1><?php echo $curauth->nickname; ?></h1>

      <nav id="profiletabs">
        <ul class="clearfix">
          <li><a href="#bio" class="sel">Обо мне</a></li>
          <li><a href="#lists">Списки фильмов</a></li>
          <li><a href="#reviews">Отзывы</a></li>
          <li><a href="#settings">Настройки</a></li>
        </ul>
      </nav>
      
      <section id="bio">
        <?php echo $curauth->user_description; ?>
      </section>
      
      <section id="lists" class="hidden">
        
      </section>
      
      <section id="reviews" class="hidden">
        <?php all_comments_user(); ?>
      </section>
      
      <section id="settings" class="hidden">
        <p>Edit your user settings:</p>
        
        <p class="setting"><span>E-mail Address <img src="images/edit.png" alt="*Edit*"></span> lolno@gmail.com</p>
        
        <p class="setting"><span>Language <img src="images/edit.png" alt="*Edit*"></span> English(US)</p>
        
        <p class="setting"><span>Profile Status <img src="images/edit.png" alt="*Edit*"></span> Public</p>
        
        <p class="setting"><span>Update Frequency <img src="images/edit.png" alt="*Edit*"></span> Weekly</p>
        
        <p class="setting"><span>Connected Accounts <img src="images/edit.png" alt="*Edit*"></span> None</p>
      </section>
    </div><!-- @end #content -->
  </div><!-- @end #w -->
<script type="text/javascript">
$(function(){
  $('#profiletabs ul li a').on('click', function(e){
    e.preventDefault();
    var newcontent = $(this).attr('href');
    
    $('#profiletabs ul li a').removeClass('sel');
    $(this).addClass('sel');
    
    $('#content section').each(function(){
      if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
    });
    
    $(newcontent).removeClass('hidden');
  });
});
</script>

<?php get_footer(); ?>