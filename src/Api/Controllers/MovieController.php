<?php

namespace Src\Api\Controllers;

use Src\Db;

class MovieController
{
    private Db $db;

    function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function readOne(): void
    {
        $movie = $this->db->getMovieById($_REQUEST["id"]);

        if ($movie !== null) {

            $response = [
                "id" => $movie['id'],
                "source_id" => $movie['source_id'],
                "name" => $movie['name'],
                "link" => $movie['link'],
                "release_year" => $movie['release_year'],
                "rating" => $movie['rating'],
                "poster" => $movie['poster'],
                "description" => $movie['description']
            ];

            http_response_code(200);

            echo json_encode($response);

        } else {
            // код ответа - 404 Не найдено
            http_response_code(404);

            // сообщим пользователю, что такой товар не существует
            echo json_encode(["message" => "Фильм не найден"], JSON_UNESCAPED_UNICODE);
        }
    }

    public function readAll(): void
    {
        $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
        $pageSize = isset($_REQUEST['page_size']) ? (int)$_REQUEST['page_size'] : 10;

        $movies = $this->db->getMovies($page, $pageSize);
        $totalMovies = $this->db->getMoviesCount();
        $totalPages = ceil($totalMovies / $pageSize);

        $response = [
            "page" => $page,
            "page_size" => $pageSize,
            "total_pages" => $totalPages,
            "total_movies" => $totalMovies,
            "movies" => $movies
        ];

        http_response_code(200);
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}

// елси нет фильма в бд вернуть 404 обработка OK
//метод получения всех фильмов с пагинацией
// передавать страницу