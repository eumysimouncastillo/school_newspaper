<?php
require_once 'classloader.php'; // adjust path if needed
// ensure only admins
$userModel = new User();
if (!$userModel->isAdmin()) {
    header("Location: login.php");
    exit;
}

$articleObj = new Article();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['createCategory'])) {
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);
        $articleObj->createCategory($name, $desc);
        header("Location: categories.php");
        exit;
    }
    if (isset($_POST['updateCategory'])) {
        $id = (int)$_POST['category_id'];
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);
        $articleObj->updateCategory($id, $name, $desc);
        header("Location: categories.php");
        exit;
    }
    if (isset($_POST['deleteCategory'])) {
        $id = (int)$_POST['category_id'];
        $articleObj->deleteCategory($id);
        header("Location: categories.php");
        exit;
    }
}

$categories = $articleObj->getCategories();
?>

<!doctype html>
<html>
<head>
    <title>Manage Categories</title>

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
<h2>Categories</h2>

<h3>Add New</h3>
<form method="post">
    <input type="text" name="name" placeholder="Category name" required>
    <input type="text" name="description" placeholder="Short description (optional)">
    <button type="submit" name="createCategory">Add</button>
</form>

<h3>Existing</h3>
<table border="1" cellpadding="6" cellspacing="0">
<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($categories as $c): ?>
<tr>
    <td><?php echo $c['category_id']; ?></td>
    <td><?php echo htmlspecialchars($c['name']); ?></td>
    <td><?php echo htmlspecialchars($c['description']); ?></td>
    <td>
        <form style="display:inline" method="post">
            <input type="hidden" name="category_id" value="<?php echo $c['category_id']; ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($c['name']); ?>" required>
            <input type="text" name="description" value="<?php echo htmlspecialchars($c['description']); ?>">
            <button type="submit" name="updateCategory">Save</button>
        </form>

        <form style="display:inline" method="post" onsubmit="return confirm('Delete this category?');">
            <input type="hidden" name="category_id" value="<?php echo $c['category_id']; ?>">
            <button type="submit" name="deleteCategory">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</body>
</html>
