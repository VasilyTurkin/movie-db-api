<?php

namespace Src;

use PDO;

class Db
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getMoviesCount(): int
    {
        $query = 'SELECT COUNT(*) as count FROM movies';
        $stmt = $this->db->query($query);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getMovieById(string $id): ?array
    {
        $checkQuery = 'SELECT * FROM movies WHERE id = :id LIMIT 1';
        $checkQuery = $this->db->prepare($checkQuery);
        $checkQuery->bindParam(':id', $id);
        $checkQuery->execute();

        $movie = $checkQuery->fetch(PDO::FETCH_ASSOC);
        return $movie !== false ? $movie : null;
    }

    public function getMovies(int $page, int $pageSize): array
    {
        $offset = ($page - 1) * $pageSize;
        $query = 'SELECT * FROM movies LIMIT :limit OFFSET :offset';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
