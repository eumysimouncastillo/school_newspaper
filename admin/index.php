<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
}  
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
    body {
      font-family: "Arial";
    }
    .article-image {
      max-width: 100%;
      height: auto;
      margin-top: 10px;
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>
  <div class="container-fluid">
    <div class="display-4 text-center">
      Hello there and welcome to the admin side! 
      <span class="text-success"><?php echo $_SESSION['username']; ?></span>. 
      Here are all the articles
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <!-- Article submission form -->
        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <input type="text" class="form-control mt-4" name="title" placeholder="Input title here" required>
          </div>
          <div class="form-group">
            <textarea name="description" class="form-control mt-4" placeholder="Message as admin" required></textarea>
          </div>
          <div class="form-group">
            <label>Upload Images (optional)</label>
            <input type="file" name="article_image[]" class="form-control" multiple>
          </div>
          <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertAdminArticleBtn" value="Post Article">
        </form>

        <!-- Article display -->
        <?php $articles = $articleObj->getActiveArticles(); ?>
        <?php foreach ($articles as $article) { ?>
          <div class="card mt-4 shadow">
            <div class="card-body">
              <h1><?php echo htmlspecialchars($article['title']); ?></h1> 
              <?php if ($article['is_admin'] == 1) { ?>
                <p><small class="bg-primary text-white p-1">Message From Admin</small></p>
              <?php } ?>
              <small>
                <strong><?php echo htmlspecialchars($article['username']); ?></strong> 
                - <?php echo $article['created_at']; ?>
              </small>
              <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>

              <!-- Display images -->
              <?php 
              $images = $articleObj->getArticleImages($article['article_id']); 
              if ($images) {
                foreach ($images as $img) { ?>
                  <img src="../writer/<?php echo htmlspecialchars($img['file_path']); ?>" class="article-image">
                <?php }
              }
              ?>

              <!-- Delete button -->
              <form action="core/handleForms.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                <button type="submit" name="deleteAdminArticleBtn" class="btn btn-danger btn-sm mt-2">
                  Delete
                </button>
              </form>
            </div>
          </div>  
        <?php } ?> 
      </div>
    </div>
  </div>
</body>
</html>
