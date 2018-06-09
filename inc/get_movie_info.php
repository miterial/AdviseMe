<?php

function get_genres($connection, $movieid = -1) {
    /*if (!mysqli_ping($connection)) {
        //die("Connection failed: " . mysqli_connect_error());
        $connection = mysqli_connect($servername, $username, $password, $dbname); //переподключение при тайм-ауте
    }*/
    $genres = array();
    if($movieid != -1) {
        $sqlById = sprintf("SELECT * FROM movies_genres WHERE id_movie='%s'", $movieid);
        $result = $connection->query($sqlById);
        if ($result->num_rows > 0) {
            $genresIDs = array();
            while($row = $result->fetch_assoc()) {
                $genresIDs[] = $row["id_genre"];
            }
            // получаем названия жанров по их id
            /*for($i = 0; $i < count($genresIDs); $i++) {
                $sql = sprintf("SELECT name FROM genres WHERE id =%s", $genresIDs[$i]);
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    $genres[] = $row['name'];
                    }
                } else {
                    echo "Жанров с таким id нет: " . $genresIDs[$i] . '</br>';
                }
            }*/
        } else {
            //echo "Жанров нет: " . $movieid . '</br>';
        }

    }
    /*else {
    	$sql = 'SELECT * FROM genres';
        $result = $connection->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $genres[] = $row["name"];
            }
        } else {
            echo "Жанров нет";
        }
    }*/
    return $genresIDs;
}

function get_countries($connection, $movieid = -1) {
    if (!mysqli_ping($connection)) {
        //die("Connection failed: " . mysqli_connect_error());
        $connection = mysqli_connect($servername, $username, $password, $dbname); //переподключение при тайм-ауте
    }
    $countries = array();
    if($movieid != -1) {
        $sqlById = sprintf("SELECT * FROM movies_countries
                    WHERE id_movie='%s'", $movieid);
        $result = $connection->query($sqlById);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                //echo 'name страны: ' .$row["name_country"] . '</br>';
                $countries[] = $row["name_country"];
            }
        } else {
            //echo "Стран нет: " . $movieid . '</br>';
        }

    }
    else {
        $sql = 'SELECT * FROM countries ORDER BY id ASC';
        $result = $connection->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $countries[] = $row["name"];
            }
        } else {
            echo "Стран нет";
        }
    }
    return $countries;
}

function get_directors($connection, $movieid = -1) {
    if (!mysqli_ping($connection)) {
        //die("Connection failed: " . mysqli_connect_error());
        $connection = mysqli_connect($servername, $username, $password, $dbname); //переподключение при тайм-ауте
    }
    $dirs = array();
    if($movieid != -1) {
        $sqlById = sprintf("SELECT * FROM movies_directors
                    WHERE id_movie='%s'", $movieid);
        $result = $connection->query($sqlById);
        if ($result->num_rows > 0) {
            $dirNames = array();
            while($row = $result->fetch_assoc()) {
                $dirs[] = $row["name_director"];
            }
        } else {
            //echo "Режиссёров нет: " . $movieid . '</br>';
        }

    }
    else {
        $sql = 'SELECT * FROM dirs';
        $result = $connection->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $dirs[] = $row["name"];
            }
        } else {
            echo "Режиссёров нет";
        }
    }
    return $dirs;
}

function get_actors($connection, $movieid = -1) {
	if (!mysqli_ping($connection)) {
        //die("Connection failed: " . mysqli_connect_error());
        $connection = mysqli_connect($servername, $username, $password, $dbname); //переподключение при тайм-ауте
    }
    $actors = array();
    if($movieid != -1) {
        $sqlById = sprintf("SELECT * FROM movies_actors WHERE id_movie =%s", $movieid);
        $result = $connection->query($sqlById);
        if ($result->num_rows > 0) {
            $actorsIDs = array();
            while($row = $result->fetch_assoc()) {
                $actorsIDs[] = $row["id_actor"];
            }
            // получаем названия жанров по их id
            for($i = 0; $i < count($actorsIDs); $i++) {
                $sql = sprintf("SELECT name FROM actors WHERE id ='%s'", $actorsIDs[$i]);

                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $lat = $row['name'];
                        $actors[] = transliterate($lat);
                    }
                } else {
                    echo "Актёров с таким id нет: " . '</br>';
                }
            }
        } else {
            echo "Актёров нет " . '</br>';
        }

    }
    else {
        $sql = 'SELECT * FROM actors';
        $result = $connection->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $lat = $row['name'];
                $actors[] = transliterate($lat);
            }
        } else {
            echo "Актёров нет";
        }
    }
    return $actors;
}

function get_movies_full($connection, $tofill = false, $movieid = -1) {
	$sqlPosts = 'SELECT id, title, alt_title, release_date, overview, poster_url, bg_url, am_score, kp_score, imdb_score FROM movies';
	if($movieid != -1)
		$sqlPosts .= ' WHERE id = $movieid';
    $resultPosts = $connection->query($sqlPosts);
    $titlesArr = array();
    $idsArr = array();
    $altTitlesArr = array();
    $dateArr = array();
    $overviewArr = array();
    $posterArr = array();
    $bgArr = array();
    $amScoreArr = array();
    $kpScoreArr = array();
    $imdbScoreArr = array();
    if ($resultPosts->num_rows > 0) {
      while($row = $resultPosts->fetch_assoc()) {
        $titlesArr[] = $row["title"];
        $idsArr[] = $row["id"];
        $altTitlesArr[] = $row["alt_title"];
        $dateArr[] = $row["release_date"];
        $overviewArr[] = $row["overview"];
        $posterArr[] = $row["poster_url"];
        $bgArr[] = $row["bg_url"];
        $amScoreArr[] = $row["am_score"];
        $kpScoreArr[] = $row["kp_score"];
        $imdbScoreArr[] = $row["imdb_score"];
      }
    }

    for($i = 0; $i < count($idsArr); $i++) {
        $movieGenresArr[] = get_genres($connection, $idsArr[$i]);
        $movieCountriesArr[] = get_countries($connection, $idsArr[$i]);
        $movieDirsArr[] = get_directors($connection, $idsArr[$i]);
        $movieActorsArr[] = get_actors($connection, $idsArr[$i]);
    }

    echo "Жанры: " . count($movieGenresArr) . '</br>';
    echo "Страны: " . count($movieCountriesArr) . '</br>';
    echo "Режиссёры: " . count($movieDirsArr) . '</br>';
    echo "Актёры: " . count($movieActorsArr) . '</br>';

    if($tofill)
    	fill_db($idsArr, $titlesArr, $altTitlesArr, $dateArr, $overviewArr, $posterArr, $bgArr, $amScoreArr, $kpScoreArr, $imdbScoreArr, $movieGenresArr, $movieCountriesArr, $movieDirsArr, $movieActorsArr);
    
    return $resultPosts;
}
