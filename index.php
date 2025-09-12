<?php require_once 'writer/classloader.php'; ?>
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
      --text-dark: #2c3e50;
      --bg-light: #f8f9fa;
      --card-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      background-attachment: fixed;
      min-height: 100vh;
    }

    .navbar {
      background: linear-gradient(45deg, var(--primary-blue), var(--primary-green));
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      padding: 1rem 2rem;
    }

    .navbar-brand {
      font-family: "Fredoka One", cursive;
      font-size: 2rem;
      color: white !important;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .navbar-brand::before {
      content: "📚";
      font-size: 2.5rem;
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
      40% { transform: translateY(-10px); }
      60% { transform: translateY(-5px); }
    }

    .container-fluid {
      background: rgba(255,255,255,0.95);
      border-radius: 20px 20px 0 0;
      margin-top: 2rem;
      padding: 2rem;
      box-shadow: var(--card-shadow);
    }

    .header-banner {
      background: linear-gradient(135deg, var(--accent-yellow), var(--accent-pink));
      padding: 2.5rem;
      border-radius: 25px;
      margin: 2rem 0;
      text-align: center;
      font-family: "Fredoka One", cursive;
      font-size: 2.5rem;
      color: white;
      box-shadow: var(--card-shadow);
      position: relative;
      overflow: hidden;
    }

    .header-banner::before {
      content: "✨";
      position: absolute;
      top: 20px;
      left: 30px;
      font-size: 2rem;
      animation: twinkle 3s infinite;
    }

    .header-banner::after {
      content: "🌟";
      position: absolute;
      top: 20px;
      right: 30px;
      font-size: 2rem;
      animation: twinkle 3s infinite 1.5s;
    }

    @keyframes twinkle {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(1.2); }
    }

    .role-card {
      background: white;
      border-radius: 20px;
      border: none;
      box-shadow: var(--card-shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
      position: relative;
    }

    .role-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    .writer-card {
      background: linear-gradient(135deg, #74b9ff, #0984e3);
    }

    .admin-card {
      background: linear-gradient(135deg, #fd79a8, #e84393);
    }

    .role-card .card-body {
      padding: 2.5rem;
      text-align: center;
      color: white;
    }

    .role-card h2 {
      font-family: "Fredoka One", cursive;
      font-size: 2rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .role-card img {
      border-radius: 15px;
      border: 4px solid rgba(255,255,255,0.3);
      transition: transform 0.3s ease;
    }

    .role-card:hover img {
      transform: scale(1.05);
    }

    .role-card p {
      font-size: 1.1rem;
      line-height: 1.6;
      margin-top: 1.5rem;
    }

    .article-card {
      background: white;
      border-radius: 20px;
      border: none;
      box-shadow: var(--card-shadow);
      transition: transform 0.3s ease;
      overflow: hidden;
      position: relative;
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
      .navbar-brand {
        font-size: 1.5rem;
      }
      
      .header-banner {
        font-size: 2rem;
        padding: 2rem 1rem;
      }
      
      .role-card .card-body {
        padding: 1.5rem;
      }
      
      .container-fluid {
        margin-top: 1rem;
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Floating background elements -->
  <div class="floating-elements">
    <div class="floating-element">🎨</div>
    <div class="floating-element">📚</div>
    <div class="floating-element">✏️</div>
    <div class="floating-element">🌟</div>
    <div class="floating-element">🎭</div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">School Publication</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <div class="container-fluid">
    <div class="header-banner">
      Welcome to Our Amazing School Newspaper! 
    </div>

    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card role-card writer-card shadow-sm">
          <div class="card-body">
            <h2><i class="fas fa-pen-fancy"></i> Writer</h2>
            <img src="https://images.unsplash.com/photo-1577900258307-26411733b430?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0" class="img-fluid my-3" alt="Writer">
            <p>Content writers create clear, engaging, and informative content to help the school communicate effectively with students, teachers, and parents.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card role-card admin-card shadow-sm">
          <div class="card-body">
            <h2><i class="fas fa-user-shield"></i> Admin</h2>
            <img src="https://plus.unsplash.com/premium_photo-1661582394864-ebf82b779eb0?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0" class="img-fluid my-3" alt="Admin">
            <p>Admins oversee the editorial process, guiding all published material to align with the school's vision and strategy, ensuring a smooth workflow.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="header-banner">
      📰 Latest Articles 📰
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <?php $articles = $articleObj->getActiveArticles(); ?>
        <?php if (empty($articles)) { ?>
          <div class="no-articles">
            <h3>No articles published yet!</h3>
            <p>Check back soon for exciting news and updates from our school community!</p>
          </div>
        <?php } else { ?>
          <?php foreach ($articles as $article) { ?>
            <div class="card article-card mb-4">
              <div class="card-body">
                <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                <?php if ($article['is_admin'] == 1) { ?>
                  <p><span class="badge-admin">Message From Admin</span></p>
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
                                <img src="writer/<?php echo htmlspecialchars($img['file_path']); ?>" class="img-fluid mb-2" alt="Article Image">
                            </div>
                <?php   } 
                    } 
                ?>
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