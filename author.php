<?php get_header(); ?>

<?php
require_once dirname( __FILE__ ) . '/inc/AM_Movie.php';

// Установка переменной текущего автора $curauth
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

$connection = db_connect();
// Данные текущего пользователя

$user = new AM_User();
$email = $user->getUserInfoFromDB("email");
$about = $user->getUserInfoFromDB("about");
$idUser = $user->getUserInfoFromDB("id");

$likedMovies = array();
$dislikedMovies = array();

// Оценённые фильмы
$sqlLike = sprintf("SELECT * FROM users_movies WHERE id_user ='%d'", $idUser);
$result = $connection->query($sqlLike);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      // Информация о фильме, с которым взаимодействовал пользователь
      $idMovie = $row["id_movie"];
      $idList = $row["id_list"];
      $rate = $row["rate"];
      $rDate = $row["rateDate"];
      // Название фильма по id
      $sqlMovie = sprintf("SELECT * FROM movies WHERE id ='%d'", $idMovie);
      $resMovie = $connection->query($sqlMovie);
      if ($resMovie->num_rows > 0) {
          while($rowMovie = $resMovie->fetch_assoc()) {
              $nameMovie = $rowMovie["title"];
          }
        }
      // Добавление фильма в массивы по спискам
      $idPost = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_title = %s", $nameMovie));

      if($idPost) {
        if($idList == 1)
          $likedMovies[] = new AM_Movie($idPost, $rDate, $rate);
        else
          $dislikedMovies[] = new AM_Movie($idPost, $rDate);
      }
    }
  }
     else echo "нет фильмов" .'</br>';
  $connection->close();

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
        <?php echo $about; ?>
      </section>
      
      <section id="lists" class="hidden">
        <h2>Просмотренные фильмы</h2>
        <?php if(count($likedMovies) > 0) :
          foreach($likedMovies as $lm) :
                $getpost = get_post($lm->getPostId()); ?>
                <div class="userlist-movie">
                  <a href="<?php echo $getpost->guid; ?>"><?php echo $getpost->post_title; ?></a> 
                  <div>
                    Оценка: <span class="inline"><?php echo $lm->getRate();?></span>
                    Дата: <span class="inline"><?php echo $lm->getDate();?></span>
                  </div>
                </div>
          <?php endforeach;
          else : echo "Нет оценённых фильмов"; 
        endif;
        ?>
        <h2>Нежелательные фильмы</h2>
        <?php if(count($dislikedMovies) > 0) :
          foreach($dislikedMovies as $lm) :
                $getpost = get_post($lm->getPostId()); ?>
                <div class="d-flex justify-space-between">
                  <a href="<?php echo $getpost->guid; ?>"><?php echo $getpost->post_title; ?></a> 
                  <div>
                    <span class="inline"><?php echo $lm->getDate();?></span>
                  </div>
                </div>
          <?php endforeach;
           else : echo "Нет нежелательных фильмов";
        endif;
        ?>
      </section>
      
      <section id="reviews" class="hidden">
        <?php all_comments_user(); ?>
      </section>
      
      <section id="settings" class="hidden">
        <p>Edit your user settings:</p>
        
        <p class="setting"><span>E-mail <img src="images/edit.png" alt="Изменить"></span> <?php echo $email; ?></p>
        
        <p class="setting"><span>Логин <img src="images/edit.png" alt="Изменить"></span> <?php echo $curauth->nickname; ?></p>
        
        <p class="setting"><span>О себе <img src="images/edit.png" alt="Изменить"></span> <?php $about; ?></p>
      </section>
    </div><!-- @end #content -->
  </div><!-- @end #w -->

<?php get_footer(); ?>
