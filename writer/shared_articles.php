<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../admin/index.php");
}  

$user_id = $_SESSION['user_id'];
$sharedArticles = $articleObj->getSharedArticles($user_id);
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <style>
    body { font-family: "Arial"; }
  </style>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>
  <div class="container-fluid">
    <div class="display-4 text-center">Shared Articles You Can Edit</div>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <?php if (!empty($sharedArticles)) : ?>
          <?php foreach ($sharedArticles as $article) : ?>
            <div class="card mt-4 shadow articleCard">
              <div class="card-body">
                <h1><?php echo $article['title']; ?></h1> 
                <small><?php echo $article['author_name'] ?> - <?php echo $article['created_at']; ?> </small>
                <p><?php echo $article['content']; ?></p>

                <?php 
                  $images = $articleObj->getArticleImages($article['article_id']); 
                  if (!empty($images)) { 
                      foreach ($images as $img) { ?>
                          <div class="mt-2">
                              <img src="<?php echo $img['file_path']; ?>" class="img-fluid mb-2" alt="Article Image">
                          </div>
                <?php   } 
                  } 
                ?>

                <!-- Double click to edit -->
                <div class="updateArticleForm d-none">
                  <h4>Edit the article</h4>
                  <form action="core/handleForms.php" method="POST">
                    <div class="form-group mt-4">
                      <input type="text" class="form-control" name="title" value="<?php echo $article['title']; ?>">
                    </div>
                    <div class="form-group">
                      <textarea name="description" class="form-control"><?php echo $article['content']; ?></textarea>
                      <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                      <input type="submit" class="btn btn-primary float-right mt-4" name="editArticleBtn">
                    </div>
                  </form>
                </div>
              </div>
            </div>  
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-info mt-4">No shared articles available.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script>
    $('.articleCard').on('dblclick', function () {
      $(this).find('.updateArticleForm').toggleClass('d-none');
    });
  </script>
</body>
</html>
