<?php  
require_once '../classloader.php';

// ==================== USER AUTH ====================

if (isset($_POST['insertNewUserBtn'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password == $confirm_password) {
            if (!$userObj->usernameExists($username)) {
                if ($userObj->registerUser($username, $email, $password)) {
                    header("Location: ../login.php");
                } else {
                    $_SESSION['message'] = "An error occurred with the query!";
                    $_SESSION['status'] = '400';
                    header("Location: ../register.php");
                }
            } else {
                $_SESSION['message'] = $username . " as username is already taken";
                $_SESSION['status'] = '400';
                header("Location: ../register.php");
            }
        } else {
            $_SESSION['message'] = "Please make sure both passwords are equal";
            $_SESSION['status'] = '400';
            header("Location: ../register.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../register.php");
    }
}

if (isset($_POST['loginUserBtn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        if ($userObj->loginUser($email, $password)) {
            header("Location: ../index.php");
        } else {
            $_SESSION['message'] = "Username/password invalid";
            $_SESSION['status'] = "400";
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../login.php");
    }
}

if (isset($_GET['logoutUserBtn'])) {
    $userObj->logout();
    header("Location: ../index.php");
}

// ==================== ARTICLE CREATION ====================

// updated to handle multiple image uploads + category
if (isset($_POST['insertArticleBtn'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author_id = $_SESSION['user_id'];
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;

    // Create the article and get its ID
    $article_id = $articleObj->createArticle($title, $description, $author_id, $category_id);

    if ($article_id) {
        // Handle image upload
        if (!empty($_FILES['article_image']['name'][0])) {
            $uploadDir = __DIR__ . '/../uploads/articles/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['article_image']['tmp_name'] as $key => $tmp_name) {
                if (!empty($_FILES['article_image']['name'][$key])) {
                    $fileName = time() . '_' . basename($_FILES['article_image']['name'][$key]);
                    $filePath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $relativePath = 'uploads/articles/' . $fileName;
                        $articleObj->addArticleImage($article_id, $relativePath);
                    }
                }
            }
        }

        header("Location: ../index.php");
    }
}

// ==================== ARTICLE EDIT/DELETE ====================

if (isset($_POST['editArticleBtn'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $article_id = $_POST['article_id'];
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;

    if ($articleObj->updateArticle($article_id, $title, $description, $category_id)) {
        header("Location: ../articles_submitted.php");
    }
}

if (isset($_POST['deleteArticleBtn'])) {
    $article_id = $_POST['article_id'];
    echo $articleObj->deleteArticle($article_id);
}

// ==================== EDIT REQUESTS ====================

if (isset($_POST['requestEditBtn'])) {
    $article_id = $_POST['article_id'];
    $requester_id = $_SESSION['user_id'];

    if ($articleObj->requestEdit($article_id, $requester_id)) {
        // Get article info to notify the owner
        $article = $articleObj->getArticles($article_id);
        $owner_id = $article['author_id'];
        $requester_name = $_SESSION['username'];
        $message = "$requester_name requested to edit this article: " . $article['title'];

        // Insert notification for the article owner
        $articleObj->addNotification($owner_id, $message);

        header("Location: ../index.php?msg=requested");
        exit;
    }
}

if (isset($_POST['edit_request_action']) && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];
    $action = $_POST['edit_request_action']; // 'accepted' or 'rejected'

    // Get request details through Article.php method
    $request = $articleObj->getEditRequestById($request_id);

    if ($request) {
        $article_id = $request['article_id'];
        $writer_id = $request['requester_id'];

        // Update request status and grant access if accepted
        $articleObj->respondToEditRequest($request_id, $action);

        // Prepare notification message
        $article = $articleObj->getArticles($article_id); 
        if ($action === 'accepted') {
            $message = "Your request to edit the article '" . $article['title'] . "' has been accepted.";
        } else {
            $message = "Your request to edit the article '" . $article['title'] . "' has been rejected.";
        }

        // Notify the writer
        $articleObj->addNotification($writer_id, $message);
    }

    // Redirect back to notifications page
    header("Location: ../notifications.php");
    exit;
}

// ==================== CATEGORY MANAGEMENT (ADMIN ONLY) ====================

// Add new category
if (isset($_POST['insertCategoryBtn']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $articleObj->createCategory($category_name);
    }
    header("Location: ../categories.php");
    exit;
}

// Update category
if (isset($_POST['updateCategoryBtn']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    $category_id = intval($_POST['category_id']);
    $category_name = trim($_POST['category_name']);
    if (!empty($category_id) && !empty($category_name)) {
        $articleObj->updateCategory($category_id, $category_name);
    }
    header("Location: ../categories.php");
    exit;
}

// Delete category
if (isset($_POST['deleteCategoryBtn']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    $category_id = intval($_POST['category_id']);
    if (!empty($category_id)) {
        $articleObj->deleteCategory($category_id);
    }
    header("Location: ../categories.php");
    exit;
}
