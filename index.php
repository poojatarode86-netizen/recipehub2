<?php include 'header.php'; ?>
<section class="hero card">
  <div>
    <h2>Cook. Share. Plan.</h2>
    <p class="kicker">Welcome to RecipeHub — Auto-backup keeps your SQL in sync.</p>
    <div class="actions">
      <?php if(isLoggedIn()): ?><a href="add_recipe.php" class="button">Share a Recipe</a><?php else: ?><a href="register.php" class="button">Get Started</a><?php endif; ?>
    </div>
  </div>
  <img src="https://picsum.photos/seed/recipehub/520/220" alt="food" class="recipe-img" style="height:220px;border-radius:14px">
</section>

<div class="form card">
  <form method="get" class="searchbar">
    <input type="text" name="q" placeholder="Search recipes..." value="<?php echo isset($_GET['q'])?htmlspecialchars($_GET['q']):''; ?>">
    <select name="category">
      <option value="">All Categories</option>
      <?php foreach(['Breakfast','Lunch','Dinner','Dessert','Snacks','Drinks','Vegan','Vegetarian','General'] as $c): ?>
        <option value="<?php echo $c; ?>" <?php echo (isset($_GET['category']) && $_GET['category']===$c)?'selected':''; ?>><?php echo $c; ?></option>
      <?php endforeach; ?>
    </select>
    <button class="button" type="submit">Search</button>
  </form>
</div>

<div class="grid">
<?php
$q = isset($_GET['q']) ? clean($_GET['q']) : '';
$cat = isset($_GET['category']) ? clean($_GET['category']) : '';
$sql = "SELECT r.*, u.name as author FROM recipes r JOIN users u ON r.user_id=u.id WHERE 1";
if($q !== ''){ $sql .= " AND (r.title LIKE '%$q%' OR r.ingredients LIKE '%$q%')"; }
if($cat !== ''){ $sql .= " AND r.category='$cat'"; }
$sql .= " ORDER BY r.created_at DESC";
$res = $mysqli->query($sql);
while($row = $res->fetch_assoc()){
  $img = $row['image'] ? 'uploads/'.$row['image'] : 'https://picsum.photos/seed/'. $row['id'] .'/600/400';
  echo '<div class="card recipe-card">';
  echo '<img class="recipe-img" src="'.htmlspecialchars($img).'" alt="">';
  echo '<h3>'.htmlspecialchars($row['title']).'</h3>';
  echo '<p class="meta">By '.htmlspecialchars($row['author']).' <span class="badge">'.htmlspecialchars($row['category']).'</span></p>';
  echo '<details><summary>Ingredients</summary><p>'.nl2br(htmlspecialchars($row['ingredients'])).'</p></details>';
  echo '<details><summary>Steps</summary><p>'.nl2br(htmlspecialchars($row['steps'])).'</p></details>';
  if (isLoggedIn() && (isAdmin() || currentUser()['id']==$row['user_id'])) {
    echo '<div class="actions"><a class="button secondary" href="edit_recipe.php?id='.$row['id'].'">Edit</a> ';
    echo '<a class="button danger" href="delete_recipe.php?id='.$row['id'].'" onclick="return confirm(\'Delete this recipe?\')">Delete</a></div>';
  }
  echo '</div>';
}
?>
</div>
<?php include 'footer.php'; ?>
