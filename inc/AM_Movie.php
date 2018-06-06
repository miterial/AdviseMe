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

    function getMovieTitle() {
        $getpost = get_post($this->id_post);
        return $getpost->post_title;
    }

    function getMovieLink() {
        $getpost = get_post($this->id_post);
        return $getpost->guid;
    }

    function getPostId() {
        return $this->id_post;
    }

    function getRate() {
        return $this->rate;
    }

    function getDate() {
        return $this->date;
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
