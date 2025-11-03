<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RecipeHub</title>
<link rel="stylesheet" href="style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="public/css/style.css" />
</head>
<body>
<header>
  <div class="container head">
    <a class="logo" href="index.php">RecipeHub</a>
    <nav>
      <a href="index.php">Home</a>
      <?php if(isLoggedIn()): ?>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="profile.php">My Recipes</a>
        <span class="welcome">Hi, <?php echo htmlspecialchars(currentUser()['name']); ?></span>
        <a href="logout.php" class="btn danger">Logout</a>
      <?php else: ?>
        <a href="register.php">Register</a>
        <a href="login.php" class="btn">Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
<?php if(isset($_SESSION['flash'])): ?>
  <div class="flash"><?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?></div>
<?php endif; ?>
