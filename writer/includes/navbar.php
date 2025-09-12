<?php
require_once 'classloader.php';

$user_id = $_SESSION['user_id'] ?? null;
$unread_count = 0;

if ($user_id) {
    $unread_count = $articleObj->getUnreadNotificationsCount($user_id);
}
?>

<nav class="navbar navbar-expand-lg navbar-dark p-4" style="background-color: #355E3B;">
  <a class="navbar-brand" href="index.php">Writer Panel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="articles_submitted.php">Articles Submitted</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="shared_articles.php">Shared Articles</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="notifications.php">
            Notifications
            <?php if ($unread_count > 0): ?>
                <span style="background:red;color:white;border-radius:50%;padding:2px 7px;font-size:12px;">
                    <?php echo $unread_count; ?>
                </span>
            <?php endif; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="core/handleForms.php?logoutUserBtn=1">Logout</a>
      </li>
    </ul>
  </div>
</nav>
