<?php
class AM_Movie {

    protected $id_post;
    protected $rate;
    protected $date;
    protected $id_movie;

    public function __construct($idMovie, $rateDate = "", $idPost = -1, $userRate = -1) {
        $this->id_post = $idPost;
        $this->rate = $userRate;
        $this->date = $rateDate;
        $this->id_movie = $idMovie;
    }

    function getPostId($idMovie = -1) {
        if($this->id_post == -1) {
            $this->idPost = $this->getPostIdByMovieId($idMovie);
        }
        return $this->id_post;
    }

    function getMovieTitle($idMovie = -1) {
        $getpost = get_post($this->getPostId($idMovie));
        return $getpost->post_title;
    }

    function getMovieLink($idMovie = -1) {
        $getpost = get_post($this->getPostId($idMovie));
        return $getpost->guid;
    }

    /**
    *   Функция получения постера фильма из БД
    *   @return string ссылка на постер
    **/
    function getMovieImage($idMovie) {
        $image = "";
        $conection = db_connect();

        $sqlMovie = sprintf("SELECT * FROM movies WHERE id ='%d'", $idMovie);
        $resMovie = $connection->query($sqlMovie);
        if ($resMovie->num_rows > 0) {
          while($rowMovie = $resMovie->fetch_assoc()) {
              $image = $rowMovie["poster_url"];
          }
        }
        $connection->close();
        return $image;
    }

    function getRate() {
        return $this->rate;
    }

    function getDate() {
        return $this->date;
    }

    function getPostIdByMovieId($idMovie) {
            // Название фильма по id
        $connection = db_connect();
        $sqlMovie = sprintf("SELECT * FROM movies WHERE id ='%d'", $idMovie);
        $resMovie = $connection->query($sqlMovie);
        if ($resMovie->num_rows > 0) {
          while($rowMovie = $resMovie->fetch_assoc()) {
              $nameMovie = $rowMovie["title"];
          }
        }
        // ID поста по названию фильма
        $id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_title = %s", $nameMovie));
        if(!$id) {
            echo "Фильма '" . $nameMovie ."' нет" . '</br>';
            return -1;
        }
        return $id;
    }

    /**
    *   Функция получения жанров текущего фильма
    *   @return Числовой массив id жанров
    **/
    function getGenres() {
        $genresIDs = array();
        //TODO: получать жанры из TMDB
        $connection = db_connect();
        if($connection != null) {
            $sqlById = sprintf("SELECT * FROM movies_genres  WHERE id_movie='%s'", $this->id_movie);
            $result = $connection->query($sqlById);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $genresIDs[] = $row["id_genre"];
                }
            } else {
                echo "Жанров нет: " . $movieid . '</br>';
                $connection->close();
                return null;
            }
        }
        $connection->close();
        return $genresIDs;
    }
}
