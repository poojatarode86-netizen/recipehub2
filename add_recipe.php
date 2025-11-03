<?php include 'header.php'; if(!isLoggedIn()){ header('Location: login.php'); exit; } ?>
<h2>Share a New Recipe</h2>
<div class="form card">
<form method="post" enctype="multipart/form-data" autocomplete="off">
  <label>Title</label>
  <input type="text" name="title" required>
  <label>Category</label>
  <select name="category" required>
    <option>Breakfast</option><option>Lunch</option><option>Dinner</option>
    <option>Dessert</option><option>Snacks</option><option>Drinks</option>
    <option>Vegan</option><option>Vegetarian</option><option>General</option>
  </select>
  <label>Cover Image</label>
  <input type="file" name="image" accept="image/*">
  <label>Ingredients (one per line)</label>
  <textarea name="ingredients" rows="6" required></textarea>
  <label>Steps</label>
  <textarea name="steps" rows="8" required></textarea>
  <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
  <button type="submit" name="publish">Publish</button>
</form>
</div>
<?php
if($_SERVER['REQUEST_METHOD']==='POST' && csrf_check()===null && isset($_POST['publish'])){
  $title = clean($_POST['title']); $cat = clean($_POST['category']); $ing = clean($_POST['ingredients']); $steps = clean($_POST['steps']);
  $imgName = null;
  if(isset($_FILES['image']) && $_FILES['image']['error']===UPLOAD_ERR_OK){
    if($_FILES['image']['size'] > 5*1024*1024){ $_SESSION['flash']='Image too large (max 5MB).'; header('Location: add_recipe.php'); exit; }
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp','gif'];
    if(in_array($ext,$allowed)){
      $imgName = time().'_'.bin2hex(random_bytes(4)).'.'.$ext;
      move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/uploads/$imgName");
    }
  }
  $uid = currentUser()['id'];
  $stmt = $mysqli->prepare("INSERT INTO recipes(user_id,title,category,ingredients,steps,image) VALUES(?,?,?,?,?,?)");
  $stmt->bind_param("isssss",$uid,$title,$cat,$ing,$steps,$imgName);
  $stmt->execute();

  // Auto-backup after create
  exportRecipes();

  $_SESSION['flash']="Recipe published!"; header('Location: index.php'); exit;
}
include 'footer.php'; ?>
