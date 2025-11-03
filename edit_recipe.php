<?php include 'header.php'; if(!isLoggedIn()){ header('Location: login.php'); exit; }
$id = isset($_GET['id'])?intval($_GET['id']):0;
$rec = $mysqli->query("SELECT * FROM recipes WHERE id=$id")->fetch_assoc();
if(!$rec){ echo '<div class="card">Recipe not found</div>'; include 'footer.php'; exit; }
if(!(isAdmin() || currentUser()['id']==$rec['user_id'])){ echo '<div class="card">Not authorized</div>'; include 'footer.php'; exit; }
?>
<h2>Edit Recipe</h2>
<div class="form card">
<form method="post" enctype="multipart/form-data">
  <label>Title</label>
  <input type="text" name="title" value="<?php echo htmlspecialchars($rec['title']); ?>" required>
  <label>Category</label>
  <input type="text" name="category" value="<?php echo htmlspecialchars($rec['category']); ?>" required>
  <label>Change Cover Image (optional)</label>
  <input type="file" name="image" accept="image/*">
  <label>Ingredients</label>
  <textarea name="ingredients" rows="6" required><?php echo htmlspecialchars($rec['ingredients']); ?></textarea>
  <label>Steps</label>
  <textarea name="steps" rows="8" required><?php echo htmlspecialchars($rec['steps']); ?></textarea>
  <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
  <button type="submit" name="save">Save Changes</button>
</form>
</div>
<?php
if($_SERVER['REQUEST_METHOD']==='POST' && csrf_check()===null && isset($_POST['save'])){
  $title = clean($_POST['title']); $cat = clean($_POST['category']); $ing = clean($_POST['ingredients']); $steps = clean($_POST['steps']);
  $imgName = $rec['image'];
  if(isset($_FILES['image']) && $_FILES['image']['error']===UPLOAD_ERR_OK){
    if($_FILES['image']['size'] > 5*1024*1024){ $_SESSION['flash']='Image too large (max 5MB).'; header('Location: edit_recipe.php?id='.$id); exit; }
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp','gif'];
    if(in_array($ext,$allowed)){
      $imgName = time().'_'.bin2hex(random_bytes(4)).'.'.$ext;
      move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/uploads/$imgName");
    }
  }
  $stmt = $mysqli->prepare("UPDATE recipes SET title=?, category=?, ingredients=?, steps=?, image=? WHERE id=?");
  $stmt->bind_param("sssssi",$title,$cat,$ing,$steps,$imgName,$id); $stmt->execute();

  // Auto-backup after update
  exportRecipes();

  $_SESSION['flash']="Recipe updated."; header("Location: index.php"); exit;
}
include 'footer.php'; ?>
