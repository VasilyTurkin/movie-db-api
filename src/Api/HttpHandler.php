<?php

namespace Src\Api;

use Src\Api\Controllers\MovieController;
use Src\Db;

class HttpHandler
{
    private Db $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function handle()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $match = [];

        if (preg_match('/^\/api\/movies\/(\d+)/', $_SERVER['REQUEST_URI'], $match)) {
            $_REQUEST['id'] = $match[1];
            if ($_SERVER["REQUEST_METHOD"] === 'GET') {
                (new MovieController($this->db))->readOne();

            } else {
                http_response_code(405);
                echo json_encode(["message" => "Method not allowed"], JSON_UNESCAPED_UNICODE);
            }

            return;
        }

        http_response_code(404);

    }
}
