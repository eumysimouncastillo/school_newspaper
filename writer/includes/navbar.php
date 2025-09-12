<?php
require_once 'classloader.php';

$user_id = $_SESSION['user_id'] ?? null;
$unread_count = 0;

if ($user_id) {
    $unread_count = $articleObj->getUnreadNotificationsCount($user_id);
}
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #6aa84f, #3d9140); box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
  <a class="navbar-brand font-weight-bold" href="index.php">
    <img src="https://img.icons8.com/color/48/000000/school.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="Logo">
    Writer Panel
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item mx-2">
        <a class="nav-link d-flex align-items-center" href="index.php">
          <img src="https://img.icons8.com/ios-filled/20/ffffff/home.png" class="mr-1" alt="Home Icon"> Home
        </a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link d-flex align-items-center" href="articles_submitted.php">
          <img src="https://img.icons8.com/ios-filled/20/ffffff/edit.png" class="mr-1" alt="Articles Icon"> Articles Submitted
        </a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link d-flex align-items-center" href="shared_articles.php">
          <img src="https://img.icons8.com/ios-filled/20/ffffff/share.png" class="mr-1" alt="Shared Icon"> Shared Articles
        </a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link d-flex align-items-center position-relative" href="notifications.php">
          <img src="https://img.icons8.com/ios-filled/20/ffffff/appointment-reminders.png" class="mr-1" alt="Notifications Icon"> Notifications
          <?php if ($unread_count > 0): ?>
            <span class="badge badge-pill badge-danger position-absolute" style="top:0; right:-10px; font-size:12px;">
                <?php echo $unread_count; ?>
            </span>
          <?php endif; ?>
        </a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link d-flex align-items-center text-warning" href="core/handleForms.php?logoutUserBtn=1">
          <img src="https://img.icons8.com/ios-filled/20/ffffff/exit.png" class="mr-1" alt="Logout Icon"> Logout
        </a>
      </li>
    </ul>
  </div>
</nav>

<!-- Optional custom styles -->
<style>
.navbar-nav .nav-item .nav-link {
    border-radius: 10px;
    transition: background 0.3s, transform 0.2s;
}
.navbar-nav .nav-item .nav-link:hover {
    background-color: rgba(255,255,255,0.2);
    transform: translateY(-2px);
}
.badge-danger {
    font-weight: bold;
    padding: 3px 7px;
}
</style>
