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
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One:wght@400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Custom Styles -->
  <style>
    :root {
      --primary-blue: #4a90e2;
      --primary-green: #7ed321;
      --accent-yellow: #f5a623;
      --accent-pink: #ff6b9d;
      --accent-purple: #9013fe;
      --accent-orange: #ff8c42;
      --text-dark: #2c3e50;
      --bg-light: #f8f9fa;
      --card-shadow: 0 8px 25px rgba(0,0,0,0.1);
      --gradient-writer: linear-gradient(135deg, #74b9ff, #0984e3);
      --gradient-success: linear-gradient(135deg, #00b894, #00cec9);
    }

    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      background-attachment: fixed;
      min-height: 100vh;
    }

    .container-fluid {
      background: rgba(255,255,255,0.95);
      border-radius: 20px 20px 0 0;
      margin-top: 0;
      padding: 2rem;
      box-shadow: var(--card-shadow);
      position: relative;
      min-height: calc(100vh - 80px);
    }

    .welcome-header {
      background: var(--gradient-writer);
      padding: 2.5rem;
      border-radius: 25px;
      margin: 2rem 0;
      text-align: center;
      font-family: "Fredoka One", cursive;
      font-size: 2rem;
      color: white;
      box-shadow: var(--card-shadow);
      position: relative;
      overflow: hidden;
    }

    .welcome-header::before {
      content: "👋";
      position: absolute;
      top: 20px;
      left: 30px;
      font-size: 2.5rem;
      animation: wave 2s infinite;
    }

    .welcome-header::after {
      content: "✏️";
      position: absolute;
      top: 20px;
      right: 30px;
      font-size: 2.5rem;
      animation: bounce 2s infinite;
    }

    @keyframes wave {
      0%, 100% { transform: rotate(0deg); }
      25% { transform: rotate(20deg); }
      75% { transform: rotate(-20deg); }
    }

    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
      40% { transform: translateY(-10px); }
      60% { transform: translateY(-5px); }
    }

    .username-highlight {
      color: var(--accent-yellow);
      font-weight: 600;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    /* Article Creation Form */
    .article-form {
      background: white;
      border-radius: 20px;
      padding: 2.5rem;
      box-shadow: var(--card-shadow);
      margin-bottom: 2rem;
      position: relative;
      border-top: 5px solid var(--primary-blue);
    }

    .article-form::before {
      content: "📝";
      position: absolute;
      top: -15px;
      left: 30px;
      background: white;
      padding: 0 10px;
      font-size: 2rem;
    }

    .form-section-title {
      font-family: "Fredoka One", cursive;
      font-size: 1.8rem;
      color: var(--text-dark);
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-section-title::before {
      content: "🎯";
      font-size: 1.5rem;
    }

    .form-control {
      border-radius: 15px;
      border: 2px solid #e0e6ed;
      padding: 1rem 1.25rem;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
      transform: translateY(-2px);
    }

    .form-control::placeholder {
      color: #a0a6b0;
      font-style: italic;
    }

    /* Category dropdown specific styling */
    .form-control-category {
      border-radius: 15px;
      border: 2px solid #e0e6ed;
      padding: 1rem 1.25rem;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      background: white !important;
      color: var(--text-dark) !important;
      width: 100%;
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      cursor: pointer;
    }

    .form-control-category:focus {
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
      transform: translateY(-2px);
      background: white !important;
      color: var(--text-dark) !important;
    }

    .form-control-category:hover {
      border-color: var(--accent-purple);
    }

    .form-control-category option {
      background: white !important;
      color: var(--text-dark) !important;
      padding: 0.75rem 1rem;
      font-size: 1.1rem;
    }

    textarea.form-control {
      min-height: 120px;
      resize: vertical;
    }

    .form-group label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 0.75rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-group label::before {
      content: "📷";
      font-size: 1.2rem;
    }

    .form-control-file {
      border: 2px dashed var(--primary-blue);
      border-radius: 15px;
      padding: 1.5rem;
      background: rgba(74, 144, 226, 0.05);
      transition: all 0.3s ease;
    }

    .form-control-file:hover {
      background: rgba(74, 144, 226, 0.1);
      border-color: var(--accent-purple);
    }

    .btn-submit {
      background: var(--gradient-success);
      border: none;
      color: white;
      padding: 1rem 2.5rem;
      border-radius: 25px;
      font-size: 1.1rem;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 0 auto;
    }

    .btn-submit::before {
      content: "🚀";
      font-size: 1.2rem;
    }

    .btn-submit:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      color: white;
    }

    /* Articles Section */
    .articles-header {
      background: linear-gradient(135deg, var(--accent-orange), var(--accent-pink));
      padding: 2rem;
      border-radius: 20px;
      margin: 3rem 0 2rem;
      text-align: center;
      font-family: "Fredoka One", cursive;
      font-size: 2rem;
      color: white;
      box-shadow: var(--card-shadow);
      position: relative;
    }

    .articles-header::before {
      content: "📰";
      position: absolute;
      top: 15px;
      left: 30px;
      font-size: 2rem;
      animation: spin 4s linear infinite;
    }

    .articles-header::after {
      content: "📚";
      position: absolute;
      top: 15px;
      right: 30px;
      font-size: 2rem;
      animation: spin 4s linear infinite reverse;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Article Cards */
    .article-card {
      background: white;
      border-radius: 20px;
      border: none;
      box-shadow: var(--card-shadow);
      transition: transform 0.3s ease;
      overflow: hidden;
      position: relative;
      margin-bottom: 2rem;
    }

    .article-card:hover {
      transform: translateY(-5px);
    }

    .article-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, var(--primary-blue), var(--primary-green), var(--accent-yellow), var(--accent-pink));
    }

    .article-card .card-body {
      padding: 2rem;
    }

    .article-card h1 {
      font-family: "Fredoka One", cursive;
      font-size: 1.8rem;
      color: var(--text-dark);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .article-card h1::before {
      content: "📄";
      font-size: 1.5rem;
    }

    .badge-admin {
      background: linear-gradient(45deg, var(--accent-purple), var(--accent-pink));
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      margin-bottom: 1rem;
    }

    .badge-admin::before {
      content: "👑";
    }

    .article-meta {
      background: var(--bg-light);
      padding: 0.75rem 1rem;
      border-radius: 10px;
      margin: 1rem 0;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.9rem;
      color: var(--text-dark);
    }

    .article-meta::before {
      content: "👤";
      font-size: 1.2rem;
    }

    .article-content {
      font-size: 1.1rem;
      line-height: 1.7;
      color: var(--text-dark);
      margin: 1.5rem 0;
    }

    .article-card img {
      border-radius: 15px;
      border: 3px solid var(--bg-light);
      transition: transform 0.3s ease;
    }

    .article-card img:hover {
      transform: scale(1.02);
    }

    /* Request Edit Buttons */
    .btn-request-edit {
      background: linear-gradient(45deg, var(--accent-yellow), var(--accent-orange));
      border: none;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 20px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-request-edit::before {
      content: "✏️";
    }

    .btn-request-edit:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      color: white;
    }

    .btn-requested {
      background: linear-gradient(45deg, #95a5a6, #7f8c8d);
      border: none;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 20px;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: not-allowed;
    }

    .btn-requested::before {
      content: "⏳";
    }

    /* Floating background elements */
    .floating-elements {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: -1;
    }

    .floating-element {
      position: absolute;
      font-size: 2rem;
      opacity: 0.1;
      animation: float 6s ease-in-out infinite;
    }

    .floating-element:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
    .floating-element:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; }
    .floating-element:nth-child(3) { top: 50%; left: 5%; animation-delay: 2s; }
    .floating-element:nth-child(4) { bottom: 30%; right: 10%; animation-delay: 3s; }
    .floating-element:nth-child(5) { bottom: 10%; left: 20%; animation-delay: 4s; }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(180deg); }
    }

    /* No articles state */
    .no-articles {
      text-align: center;
      padding: 3rem;
      color: var(--text-dark);
    }

    .no-articles::before {
      content: "📝";
      font-size: 4rem;
      display: block;
      margin-bottom: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .welcome-header {
        font-size: 1.5rem;
        padding: 2rem 1rem;
      }
      
      .article-form {
        padding: 1.5rem;
      }
      
      .container-fluid {
        margin-top: 1rem;
        padding: 1rem;
      }
      
      .form-section-title {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <!-- Floating background elements -->
  <div class="floating-elements">
    <div class="floating-element">✏️</div>
    <div class="floating-element">📝</div>
    <div class="floating-element">🎨</div>
    <div class="floating-element">📚</div>
    <div class="floating-element">🌟</div>
  </div>

  <?php include 'includes/navbar.php'; ?>
  
  <div class="container-fluid">
    <div class="welcome-header">
      Hello there and welcome! <span class="username-highlight"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
    </div>
    
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!-- Article Creation Form -->
        <div class="article-form">
          <div class="form-section-title">Create New Article</div>
          <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <input type="text" class="form-control" name="title" placeholder="✨ Enter an amazing title for your article...">
            </div>

            <?php
            // Load categories from database
            $categories = $articleObj->getCategories();
            ?>
            <div class="form-group">
              <label for="category_id">🗂️ Choose a Category (optional)</label>
              <select name="category_id" id="category_id" class="form-control-category">
                <option value="">-- Uncategorised --</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?php echo $cat['category_id']; ?>">
                    <?php echo htmlspecialchars($cat['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <textarea name="description" class="form-control" placeholder="📖 Share your story with the school community..."></textarea>
            </div>

            <!-- Image upload field -->
            <div class="form-group">
              <label for="article_image">Add Some Pictures!</label>
              <input type="file" name="article_image[]" id="article_image" class="form-control-file" multiple>
              <small class="form-text text-muted">📷 You can select multiple images to make your article more engaging!</small>
            </div>

            <div class="text-center">
              <input type="submit" class="btn btn-submit" name="insertArticleBtn" value="Publish Article">
            </div>
          </form>
        </div>


        <!-- Articles Header -->
        <div class="articles-header">
          All Published Articles
        </div>

        <!-- Articles List -->
        <?php $articles = $articleObj->getActiveArticles(); ?>
        <?php if (empty($articles)) { ?>
          <div class="no-articles">
            <h3>No articles published yet!</h3>
            <p>Be the first to share something amazing with your school community!</p>
          </div>
        <?php } else { ?>
          <?php foreach ($articles as $article) { ?>
            <div class="card article-card">
              <div class="card-body">
                <h1><?php echo htmlspecialchars($article['title']); ?></h1> 
                <?php if ($article['is_admin'] == 1) { ?>
                  <div class="badge-admin">Message From Admin</div>
                <?php } ?>
                <div class="article-meta">
                  <strong><?php echo htmlspecialchars($article['username']); ?></strong> • 
                  <span><?php echo $article['created_at']; ?></span>
                </div>
                <div class="article-content">
                  <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                </div>

                <?php 
                    $images = $articleObj->getArticleImages($article['article_id']); 
                    if (!empty($images)) { 
                        foreach ($images as $img) { ?>
                            <div class="mt-3">
                                <img src="<?php echo htmlspecialchars($img['file_path']); ?>" class="img-fluid mb-2" alt="Article Image">
                            </div>
                <?php   } 
                    } 
                ?>

                <!-- Request Edit Button -->
                <?php 
                $user_id = $_SESSION['user_id'];
                if ($article['author_id'] != $user_id) {
                    $hasRequested = $articleObj->hasRequestedEdit($article['article_id'], $user_id);
                ?>
                    <form method="POST" action="core/handleForms.php" class="mt-3">
                        <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                        <?php if ($hasRequested) { ?>
                            <button type="button" class="btn btn-requested" disabled>Already Requested</button>
                        <?php } else { ?>
                            <button type="submit" name="requestEditBtn" class="btn btn-request-edit">Request Edit</button>
                        <?php } ?>
                    </form>
                <?php } ?>

              </div>
            </div>  
          <?php } ?>
        <?php } ?>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>