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
    public function createArticle($title, $content, $author_id) {
        $sql = "INSERT INTO articles (title, content, author_id, is_active) VALUES (?, ?, ?, 0)";
        $this->executeNonQuery($sql, [$title, $content, $author_id]);
        return $this->pdo->lastInsertId(); // <-- real article_id
    }


    /**
     * Retrieves articles from the database.
     * @param int|null $id The article ID to retrieve, or null for all articles.
     * @return array
     */
    public function getArticles($id = null) {
        if ($id) {
            $sql = "SELECT * FROM articles WHERE article_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT * FROM articles JOIN school_publication_users ON articles.author_id = school_publication_users.user_id ORDER BY articles.created_at DESC";
        return $this->executeQuery($sql);
    }

    public function getActiveArticles($id = null) {
        if ($id) {
            $sql = "SELECT * FROM articles WHERE article_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT * FROM articles 
                JOIN school_publication_users ON 
                articles.author_id = school_publication_users.user_id 
                WHERE is_active = 1 ORDER BY articles.created_at DESC";
                
        return $this->executeQuery($sql);
    }

    public function getArticlesByUserID($user_id) {
        $sql = "SELECT * FROM articles 
                JOIN school_publication_users ON 
                articles.author_id = school_publication_users.user_id
                WHERE author_id = ? ORDER BY articles.created_at DESC";
        return $this->executeQuery($sql, [$user_id]);
    }

    /**
     * Updates an article.
     * @param int $id The article ID to update.
     * @param string $title The new title.
     * @param string $content The new content.
     * @return int The number of affected rows.
     */
    public function updateArticle($id, $title, $content) {
        $sql = "UPDATE articles SET title = ?, content = ? WHERE article_id = ?";
        return $this->executeNonQuery($sql, [$title, $content, $id]);
    }
    
    /**
     * Toggles the visibility (is_active status) of an article.
     * This operation is restricted to admin users only.
     * @param int $id The article ID to update.
     * @param bool $is_active The new visibility status.
     * @return int The number of affected rows.
     */
    public function updateArticleVisibility($id, $is_active) {
        $userModel = new User();
        if (!$userModel->isAdmin()) {
            return 0;
        }
        $sql = "UPDATE articles SET is_active = ? WHERE article_id = ?";
        return $this->executeNonQuery($sql, [(int)$is_active, $id]);
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

    // Inside Article.php class
    public function getNotificationsByUser($user_id) {
        $sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
        return $this->executeQuery($sql, [$user_id]);
    }

    // Optional: mark notifications as read
    public function markNotificationsAsRead($user_id) {
        $sql = "UPDATE notifications SET is_read = 1 WHERE user_id = ?";
        return $this->executeNonQuery($sql, [$user_id]);
    }

    // Inside Article.php
    public function getUnreadNotificationsCount($user_id) {
        $sql = "SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = ? AND is_read = 0";
        $result = $this->executeQuerySingle($sql, [$user_id]);
        return $result ? $result['unread_count'] : 0;
    }

    public function hasRequestedEdit($article_id, $writer_id) {
        $sql = "SELECT * FROM article_edit_requests WHERE article_id = ? AND requester_id = ? AND status='pending'";
        return $this->executeQuerySingle($sql, [$article_id, $writer_id]) ? true : false;
    }

    public function requestEdit($article_id, $requester_id) {
        $sql = "INSERT INTO article_edit_requests (article_id, requester_id) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$article_id, $requester_id]);
    }

    public function getPendingEditRequests($owner_id) {
        $sql = "SELECT aer.request_id, aer.article_id, aer.requester_id, a.title, u.username 
                FROM article_edit_requests aer
                JOIN articles a ON aer.article_id = a.article_id
                JOIN school_publication_users u ON aer.requester_id = u.user_id
                WHERE a.author_id = ? AND aer.status='pending'
                ORDER BY aer.created_at DESC";
        return $this->executeQuery($sql, [$owner_id]);
    }

    public function respondToEditRequest($request_id, $status) {
        // Update request status
        $sql = "UPDATE article_edit_requests SET status=? WHERE request_id=?";
        $this->executeNonQuery($sql, [$status, $request_id]);

        // If accepted, grant edit access
        if ($status == 'accepted') {
            $sql2 = "INSERT INTO article_shared_access (article_id, writer_id, granted_by)
                    SELECT article_id, requester_id, (SELECT author_id FROM articles WHERE article_id=aer.article_id) 
                    FROM article_edit_requests aer WHERE request_id=?";
            $this->executeNonQuery($sql2, [$request_id]);
        }

        return true;
    }

    public function getSharedArticles($writer_id) {
        $sql = "SELECT a.*, u.username AS author_name
                FROM article_shared_access asa
                JOIN articles a ON asa.article_id = a.article_id
                JOIN school_publication_users u ON a.author_id = u.user_id
                WHERE asa.writer_id = ?
                ORDER BY a.created_at DESC";
        return $this->executeQuery($sql, [$writer_id]);
    }

    // Add a notification for a user
    public function addNotification($user_id, $message) {
        $sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$user_id, $message]);
    }





}
?>