<?php  

require_once 'Database.php';
require_once 'User.php';
/**
 * Class for handling Article-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Article extends Database {
    /**
     * Creates a new article.
     * @param string $title The article title.
     * @param string $content The article content.
     * @param int $author_id The ID of the author.
     * @return int The ID of the newly created article.
     */
    public function createArticle($title, $content, $author_id, $category_id = null) {
        $sql = "INSERT INTO articles (title, category_id, content, author_id, is_active) VALUES (?, ?, ?, ?, 1)";
        $this->executeNonQuery($sql, [$title, $category_id, $content, $author_id]);
        return $this->pdo->lastInsertId();
    }


    /**
     * Retrieves articles from the database.
     * @param int|null $id The article ID to retrieve, or null for all articles.
     * @return array
     */
    public function getArticles($id = null) {
        if ($id) {
            $sql = "SELECT a.*, u.username, u.is_admin, c.name AS category_name
                    FROM articles a
                    JOIN school_publication_users u ON a.author_id = u.user_id
                    LEFT JOIN categories c ON a.category_id = c.category_id
                    WHERE a.article_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT a.*, u.username, u.is_admin, c.name AS category_name
                FROM articles a
                JOIN school_publication_users u ON a.author_id = u.user_id
                LEFT JOIN categories c ON a.category_id = c.category_id
                ORDER BY a.created_at DESC";
        return $this->executeQuery($sql);
    }

    public function getActiveArticles($id = null) {
        if ($id) {
            $sql = "SELECT a.*, u.username, u.is_admin, c.name AS category_name
                    FROM articles a
                    JOIN school_publication_users u ON a.author_id = u.user_id
                    LEFT JOIN categories c ON a.category_id = c.category_id
                    WHERE a.article_id = ? AND a.is_active = 1";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT a.*, u.username, u.is_admin, c.name AS category_name
                FROM articles a
                JOIN school_publication_users u ON a.author_id = u.user_id
                LEFT JOIN categories c ON a.category_id = c.category_id
                WHERE a.is_active = 1
                ORDER BY a.created_at DESC";
        return $this->executeQuery($sql);
    }

    public function getArticlesByUserID($user_id) {
        $sql = "SELECT a.*, u.username, u.is_admin, c.name AS category_name
                FROM articles a
                JOIN school_publication_users u ON a.author_id = u.user_id
                LEFT JOIN categories c ON a.category_id = c.category_id
                WHERE a.author_id = ?
                ORDER BY a.created_at DESC";
        return $this->executeQuery($sql, [$user_id]);
    }




    /**
     * Updates an article.
     * @param int $id The article ID to update.
     * @param string $title The new title.
     * @param string $content The new content.
     * @return int The number of affected rows.
     */
    public function updateArticle($id, $title, $content, $category_id = null) {
        $sql = "UPDATE articles SET title = ?, content = ?, category_id = ? WHERE article_id = ?";
        return $this->executeNonQuery($sql, [$title, $content, $category_id, $id]);
    }

    
    /**
     * Toggles the visibility (is_active status) of an article.
     * This operation is restricted to admin users only.
     * @param int $id The article ID to update.
     * @param bool $is_active The new visibility status.
     * @return int The number of affected rows.
     */
    public function updateArticleVisibility($id, $is_active) {
        $sql = "UPDATE articles SET is_active = ? WHERE article_id = ?";
        return $this->executeNonQuery($sql, [$is_active, $id]);
    }


    /**
     * Deletes an article.
     * @param int $id The article ID to delete.
     * @return int The number of affected rows.
     */
    public function deleteArticle($id) {
        $sql = "DELETE FROM articles WHERE article_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }

    // add image function
    public function addArticleImage($article_id, $file_path) {
        $sql = "INSERT INTO article_images (article_id, file_path) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$article_id, $file_path]);
    }

    // fetch all images for an article
    public function getArticleImages($article_id) {
        $sql = "SELECT * FROM article_images WHERE article_id = ?";
        return $this->executeQuery($sql, [$article_id]);
    }

    // Add this inside the Article class
    public function addNotification($user_id, $message) {
        $sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$user_id, $message]);
    }

    // Categories CRUD
    public function createCategory($name, $description = null) {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$name, $description]);
    }

    public function getCategories($id = null) {
        if ($id) {
            $sql = "SELECT * FROM categories WHERE category_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->executeQuery($sql);
    }

    public function updateCategory($id, $name, $description = null) {
        $sql = "UPDATE categories SET name = ?, description = ? WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$name, $description, $id]);
    }

    public function deleteCategory($id) {
        // This will set articles.category_id to NULL because of ON DELETE SET NULL
        $sql = "DELETE FROM categories WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }



}
?>