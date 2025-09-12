<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../admin/index.php");
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
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
      <div class="display-4 text-center">Hello there and welcome! <span class="text-success"><?php echo $_SESSION['username']; ?></span>. Here are all the articles</div>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control mt-4" name="title" placeholder="Input title here">
            </div>
            <div class="form-group">
                <textarea name="description" class="form-control mt-4" placeholder="Submit an article!"></textarea>
            </div>
            <!-- ✅ New image upload field -->
            <div class="form-group">
                <label for="article_image">Upload Images</label>
                <input type="file" name="article_image[]" id="article_image" class="form-control-file" multiple>
                <small class="form-text text-muted">You may select multiple images.</small>
            </div>
            <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertArticleBtn">
          </form>

          <?php $articles = $articleObj->getActiveArticles(); ?>
          <?php foreach ($articles as $article) { ?>
          <div class="card mt-4 shadow">
            <div class="card-body">
              <h1><?php echo $article['title']; ?></h1> 
              <?php if ($article['is_admin'] == 1) { ?>
                <p><small class="bg-primary text-white p-1">  
                  Message From Admin
                </small></p>
              <?php } ?>
              <small><strong><?php echo $article['username'] ?></strong> - <?php echo $article['created_at']; ?> </small>
              <p><?php echo $article['content']; ?> </p>

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

              <!-- ✅ Request Edit Button -->
              <?php 
              $user_id = $_SESSION['user_id'];
              if ($article['author_id'] != $user_id) {
                  $hasRequested = $articleObj->hasRequestedEdit($article['article_id'], $user_id);
              ?>
                  <form method="POST" action="core/handleForms.php" class="mt-2">
                      <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                      <?php if ($hasRequested) { ?>
                          <button type="button" class="btn btn-secondary btn-requested" disabled>Requested Already</button>
                      <?php } else { ?>
                          <button type="submit" name="requestEditBtn" class="btn btn-primary">Request Edit</button>
                      <?php } ?>
                  </form>
              <?php } ?>

            </div>
          </div>  
          <?php } ?>

        </div>
      </div>
    </div>
  </body>
</html>