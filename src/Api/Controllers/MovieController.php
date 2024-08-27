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

    public function readOne()
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
}

// елси нет фильма в бд вернуть 404 обработка OK
//метод получения всех фильмов с пагинацией
// передавать страницу