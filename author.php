<?php get_header(); 

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
$sqlLike = sprintf("SELECT * FROM users_movies WHERE id_user ='%d' ORDER BY id DESC", $idUser);
$result = $connection->query($sqlLike);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      // Информация о фильме, с которым взаимодействовал пользователь
      //TODO: Выбирать последнюю поставленную оценку/список
      $idMovie = $row["id_movie"];
      $idList = $row["id_list"];
      $rate = $row["rate"];
      $rDate = $row["rateDate"];

      $sqlMovie = sprintf("SELECT * FROM movies WHERE id ='%d'", $idMovie);
        $resMovie = $connection->query($sqlMovie);
        if ($resMovie->num_rows > 0) {
          while($rowMovie = $resMovie->fetch_assoc()) {
              $nameMovie = $rowMovie["title"];
          }
        }
      
        // Если это последняя (актуальная) запись по данному фильму
       /* if(!strcmp($likedMovies[$i]->getMovieTitle(), $nameMovie) || 
          !strcmp($dislikedMovies[$i]->getMovieTitle(), $nameMovie)) {*/
      // Добавление фильма в массивы по спискам
          $idPost = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_title = %s", $nameMovie));

          if($idPost) {
            if($idList == 1)
              $likedMovies[] = new AM_Movie($idMovie, $rDate, $idPost, $rate);
            else
              $dislikedMovies[] = new AM_Movie($idMovie,  $rDate, $idPost);
          }
        /*}*/
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
          <li><a href="#bio">Обо мне</a></li>
          <li><a href="#lists">Списки фильмов</a></li>
          <li><a href="#recommended" class="sel">Рекомендации</a></li>
          <li><a href="#reviews">Отзывы</a></li>
          <li><a href="#settings">Настройки</a></li>
        </ul>
      </nav>
      
      <section id="bio" class="hidden">
        <?php echo $about; ?>
      </section>
      
      <section id="lists" class="hidden">
        <h2>Просмотренные фильмы</h2>
        <?php if(count($likedMovies) > 0) :
          foreach($likedMovies as $lm) :
                 ?>
                <div class="userlist-movie">
                  <a href="<?php echo $lm->getMovieLink(); ?>"><?php echo $lm->getMovieTitle(); ?></a> 
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
                 ?>
                <div class="userlist-movie">
                  <a href="<?php echo $lm->getMovieLink(); ?>"><?php echo $lm->getMovieTitle(); ?></a> 
                  <div>
                    Дата: <span class="inline"><?php echo $lm->getDate();?></span>
                  </div>
                </div>
          <?php endforeach;
           else : echo "Нет нежелательных фильмов";
        endif;
        ?>
      </section>
      <section id="recommended">
        <?php
          $m = new Recommendation();
          //$m->fillTable();
          $userMovies = $m->getUserRecommendations($idUser);
          if(count($userMovies) > 0) {
          echo "<h2>Всего фильмов: ".count($userMovies).'</h2>';

          $connection = db_connect();
          for($i = 0; $i < 90; $i++) {
            $sqlMovieName = sprintf("SELECT * FROM movies WHERE id ='%d'", $userMovies[$i]->getMovieID());
            $result = $connection->query($sqlMovieName);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $idPost = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_title = %s", $row['title']));
                  if($idPost) { 
                    //echo "postID: ".$idPost.'</br>';
                    $userMovies[$i]->setPostId($idPost);
                  }
                }
              }
            }
            $connection->close();
            echo '<div id="filterRes">';
            for($i = 0; $i < 90; $i++) {
               echo '<div class="filtered-movies--item">';
                echo '<a href="'.$userMovies[$i]->getMovieLink() .'"><img src="'. $userMovies[$i]->getMovieImage($userMovies[$i]->getMovieID()) .'" alt="movie" width="150px" style="height: 210px"/>'.$userMovies[$i]->getMovieTitle().'</a></div>';
            }
             echo '</div>';
             echo '<div class="text-center"><a href="#">Показать больше</a></div>';
           }
           else echo "<h3>Нет рекомендованных фильмов</h3>";
        ?>
      </section>
      
      <section id="reviews" class="hidden">
        <?php all_comments_user(); ?>
      </section>
      
      <section id="settings" class="hidden">
        <p>Edit your user settings:</p>
        
        <p class="setting"><span>E-mail <img src="images/edit.png" alt="Изменить"></span> <?php echo $email; ?></p>
        
        <p class="setting"><span>Логин <img src="images/edit.png" alt="Изменить"></span> <?php echo $curauth->nickname; ?></p>
        
        <p class="setting"><span>О себе <img src="images/edit.png" alt="Изменить"></span> Мне нравится фантастика и комедии. Люблю выбирать фильмы :) </p>
      </section>
    </div><!-- @end #content -->
  </div><!-- @end #w -->

<?php get_footer(); ?>
