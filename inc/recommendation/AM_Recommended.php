<?php
/**
* Класс Recommendation используется для получения списка фильмов, похожих на
* те, которые просмотрел пользователь
**/
class Recommendation {
    function __construct() {

    }

    /**
    *   Функция заполнения таблицы coefficients
    **/
    function fillTable() {
      $connection = db_connect();
        // Получение ID всех фильмов, кроме текущего и всех, с которыми уже было сравнение
        $moviesIDs = array();
        $sqlMovie = "SELECT id FROM movies WHERE id > '24102'";
        $result = $connection->query($sqlMovie);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $this->compareMoviePair($id);
            }
        }
        $connection->close();
    }
    /**
    *   Функция получения коэффициентов Жаккара для одного фильма по всем остальным
    **/
    function compareMoviePair($idMovie) {
            echo "ID текущего фильма: ".$idMovie . '</br>';
        $movie = new AM_Movie($idMovie);
        $movieGenres = $movie->getGenres();
        if($movieGenres) {  // Если у текущего фильма есть жанры

            $connection = db_connect();
            // Получение ID всех фильмов, кроме текущего и всех, с которыми уже было сравнение
            $moviesIDs = array();
            $sqlMovies = sprintf("SELECT id FROM movies WHERE id != '%s' AND id NOT IN (SELECT id_movie_1 FROM coefficients WHERE id_movie_2 = '%s')", $idMovie, $idMovie);
            $result = $connection->query($sqlMovies);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $moviesIDs[] = $row["id"];
                }
            }
            //$connection->close();
            //echo "Поиск id завершён" . '</br>';

            // int, Массив id жанров по каждому из фильмов
            $genresToCompare = array();
            // int, Массив количества жанров каждого из фильмов
            $genresCountToCompare = array();

            // Получение жанров всех фильмов
            foreach($moviesIDs as $id) {
                $genresToCompare[] = get_genres($connection, $id);
                // Получение количества жанров в текущем фильме
                $genresCountToCompare[] = count($genresToCompare[count($genresToCompare) - 1]);
            }
            echo "Поиск жанров всех фильмов завершён" . '</br>';

            // Количество общих жанров с другими фильмами
            $commonGenresCount = array();
            foreach($genresToCompare as $gtc) {  // массив жанров выбранного фильма
                $k = 0;
                foreach($movieGenres as $mg) { //массив жанров всех остальных фильмов
                    if($gtc)
                        if(in_array($mg, $gtc))     // Если среди жанров содержится текущий жанр выбранного фильма
                                $k++;
                }
                array_push($commonGenresCount, $k);
            }
            //echo "Поиск общих жанров завершён" . '</br>';

            // Получение коэффициента для двух фильмов
            for($i = 0; $i < count($moviesIDs); $i++){
                $value = $this->getJaccardCoefficient(count($movieGenres), $genresCountToCompare[$i],
                                                        $commonGenresCount[$i]);
                if($value >= 0.6)
                    $this->writePairToDatabase($value, $idMovie, $moviesIDs[$i]);
            }
        }
        else
            echo "Невозможно получить коэффициент: у данного фильма нет жанров" . '</br>';
            // INSERT -1

    }    
    /**
    *   Функция нахождения коэффициента Жаккара для двух фильмов
    **/
    function getJaccardCoefficient($a, $b, $c) {
        if($a == 0 || $b == 0)
            return 0;
        return ($c / ($a + $b - $c));
    }
    /**
    *   Функция записи коэффициента Жаккара для двух фильмов в БД
    **/
    function writePairToDatabase($coefficient, $idMovie1, $idMovie2) {
        $connection = db_connect();
        // Получение ID всех фильмов, кроме текущего и всех, с которыми уже было сравнение
        $sqlCoef = "INSERT INTO coefficients (id_movie_1, id_movie_2, value) VALUES('". $idMovie1 ."', '". $idMovie2 ."', ". $coefficient .")";
            if (!mysqli_query($connection, $sqlCoef)) {
                echo mysqli_error($connection);
            }
        $connection->close();
    }

    /**
    *   Функция получения рекомендованных фильмов
    *   @return одномерный массив объектов AM_Movie
    **/
    function getUserRecommendations($id_user) {
        // Массив итоговых объектов AM_Movie
        $userMovies = array();
        // Массив уникальных id рекомендованных фильмов
        $movieIDs = array();

        // Получение всех фильмов, которые оценил пользователь
        $sqlUserMovies = sprintf("SELECT * FROM users_movies WHERE id_user ='%d'", $id_user);
        $result = $connection->query($sqlUserMovies);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['id_list'] != 2) {  // Если фильм не помечен нежелательным
                    $temp = array();
                    $curID = $row['id_movie'];
                    if($moviesIDs && in_array($curID, $moviesIDs)) {   // Если в массив попадает id 
                        $moviesIDs = array_diff($moviesIDs, [$curID]);  // удаляем его из общего массива
                        $moviesIDs = array_values($moviesIDs);      // переиндексация, чтобы не было пустях значений.
                    }
                    // Выбор фильмов
                    $curMovieSimilarsIDs = $this->getSimilarMovies($curID);
                    // Составление списка фильмов
                    foreach ($curMovieSimilarsIDs as $id) {
                        array_push($moviesIDs, $id);  // добавление всех id по текущему фильму
                        $moviesIDs = array_unique($moviesIDs);  // Удаление повторяющихся фильмов
                    }

                }
            }
            foreach($moviesIDs as $id) {
                array_push($userMovies, new AM_Movie($id));
            }
        }

        return $userMovies;
    }

    /**
    *   Функция получения фильмов, похожих на текущий
    *   @return массив объектов AM_Movie
    **/
    function getSimilarMovies($id_movie) {
        // Массив ID рекомендованных фильмов
        $recommendedMovieID = array();

        $sqlRecomMovies = sprintf("SELECT * FROM coefficients WHERE id_movie_1 ='%d' AND value > '0,7'", $id_movie);
        $resultRecom = $connection->query($sqlRecomMovies);
        if ($resultRecom->num_rows > 0) {
            while($rowRecom = $resultRecom->fetch_assoc()) {
                $recommendedMovieID[] = $row['id_movie_2'];
            }
        }

        return $recommendedMovieID;
    }
}
