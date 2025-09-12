<?php require_once 'writer/classloader.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <style>
    body { font-family: "Arial"; }
    .btn-requested { cursor: not-allowed; opacity: 0.7; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark p-4" style="background-color: #355E3B;">
  <a class="navbar-brand" href="#">School Publication Homepage</a>
</nav>

<div class="container-fluid">
  <div class="display-4 text-center">Hello there and welcome to the main homepage!</div>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <?php 
      $user_id = $_SESSION['user_id'];
      $articles = $articleObj->getActiveArticles(); 
      foreach ($articles as $article) { ?>
        <div class="card mt-4 shadow">
          <div class="card-body">
            <h1><?php echo $article['title']; ?></h1>
            <?php if ($article['is_admin'] == 1) { ?>
              <p><small class="bg-primary text-white p-1">Message From Admin</small></p>
            <?php } ?>
            <small><strong><?php echo $article['username'] ?></strong> - <?php echo $article['created_at']; ?> </small>
            <p><?php echo $article['content']; ?> </p>

            <?php 
            $images = $articleObj->getArticleImages($article['article_id']); 
            if (!empty($images)) { 
                foreach ($images as $img) { ?>
                    <div class="mt-2">
                        <img src="writer/<?php echo $img['file_path']; ?>" class="img-fluid mb-2" alt="Article Image">
                    </div>
            <?php } } ?>

            <?php 
            // Show Request Edit button only if the article is NOT yours
            if ($article['author_id'] != $user_id) {
                $hasRequested = $articleObj->hasRequestedEdit($article['article_id'], $user_id); 
            ?>
                <form method="POST" action="writer/core/handleForms.php" class="mt-2">
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
