<?php
/**
* Класс Recommendation используется для получения списка фильмов, похожих на
* те, которые просмотрел пользователь
**/
class Recommendation {
    function __construct() {

    }
    /**
    *   Функция получения коэффициентов Жаккара для одного фильма по всем остальным
    **/
    function compareMoviePair($idMovie) {
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
            $connection->close();
            echo "Поиск id завершён" . '</br>';

            // int, Массив id жанров по каждому из фильмов
            $genresToCompare = array();
            // int, Массив количества жанров каждого из фильмов
            $genresCountToCompare = array();

            // Получение жанров всех фильмов
            foreach($moviesIDs as $id) {
                $temp = new AM_Movie($id);
                $genresToCompare[] = $temp->getGenres();
                // Получение количества жанров в текущем фильме
                $genresCountToCompare[] = count($genresToCompare[count($genresToCompare) - 1]);
            }
            echo "Поиск жанров всех фильмов завершён" . '</br>';

            // Количество общих жанров с другими фильмами
            $commonGenresCount = array();
            $y = 0;
            foreach($genresToCompare as $gtc) {  // массив жанров выбранного фильма
                $k = 0;
                foreach($movieGenres as $mg) { //массив жанров всех остальных фильмов
                    if(in_array($mg, $gtc))     // Если среди жанров содержится текущий жанр выбранного фильма
                            $k++;
                }
                array_push($commonGenresCount, $k);
            }
            echo "Поиск общих жанров завершён" . '</br>';

            // Получение коэффициента для двух фильмов
            for($i = 0; $i < count($moviesIDs); $i++){
            echo count($movieGenres) . "_" .$genresCountToCompare[$i] ."_".$commonGenresCount[$i]  . '</br>';
                $value = $this->getJaccardCoefficient(count($movieGenres), $genresCountToCompare[$i],
                                                        $commonGenresCount[$i]);
                echo $value . '</br>';
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
}

