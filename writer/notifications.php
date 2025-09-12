<?php
require_once 'classloader.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch notifications through Article class method
$notifications = $articleObj->getNotificationsByUser($user_id);

// Mark all as read
$articleObj->markNotificationsAsRead($user_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
        body { font-family: "Arial", sans-serif; }
        .notification-card { margin-bottom: 10px; }
        .notification-unread { background-color: #eaf3ff; font-weight: bold; }
        .timestamp { font-size: 0.85rem; color: #6c757d; }
    </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Notifications</h2>

    <?php if (!empty($notifications)): ?>
        <div class="list-group">
            <?php foreach ($notifications as $note): ?>
                <div class="list-group-item notification-card <?php echo $note['is_read'] == 0 ? 'notification-unread' : ''; ?>">
                    <p class="mb-1"><?php echo htmlspecialchars($note['message']); ?></p>
                    <small class="timestamp"><?php echo $note['created_at']; ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No notifications yet.</div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc3+ogpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

</body>
</html>
