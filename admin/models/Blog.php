<?php 

namespace LH\Models;

use LH\Utils\Database;

class Blog
{

    public function getAllPosts(int $limit, int $offset): array
    {
        $stmt = Database::getInstance()->prepare(
            "SELECT * FROM blogs ORDER BY created_at DESC LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalPosts(): int
    {
        $stmt = Database::getInstance()->query("SELECT COUNT(*) FROM blogs");
        return (int)$stmt->fetchColumn();
    }

    public function getPostById(int $id): ?array
    {
        $stmt = Database::getInstance()->prepare("SELECT * FROM blogs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createPost(string $title, string $description, ?string $image): bool
    {
        $stmt = Database::getInstance()->prepare(
            "INSERT INTO blogs (title, description, image) VALUES (:title, :description, :image)"
        );
        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'image' => $image
        ]);
    }

    public function updatePost(int $id, string $title, string $description, ?string $image = null): bool
    {
        $sql = "UPDATE blogs SET title = :title, description = :description";
        
        if ($image) {
            $sql .= ", image = :image";
        }

        $sql .= " WHERE id = :id";

        $stmt = Database::getInstance()->prepare($sql);
        $params = [
            ':title' => $title,
            ':description' => $description,
            ':id' => $id
        ];

        if ($image) {
            $params[':image'] = $image;
        }

        return $stmt->execute($params);
    }

    public function deletePost(int $id): bool
    {
        $stmt = Database::getInstance()->prepare("DELETE FROM blogs WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}