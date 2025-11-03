RecipeHub — Auto-Backup Edition

What you get:
- Professional PHP app (recipes with image uploads)
- Auto-backup: on every Add/Edit/Delete, exports fresh data to sql/recipes_data.sql
- uploads/ (place your images here; new uploads save here automatically)

Setup (XAMPP):
1) Copy the 'RecipeHub' folder to C:/xampp/htdocs/
2) Import sql/recipehub.sql in phpMyAdmin (creates tables + demo user)
3) Visit: http://localhost/RecipeHub/
4) Login: create new user OR demo@recipehub.local / demo123

Auto-backup details:
- File: sql/recipes_data.sql
- Triggered after create/update/delete in app
- Share this file + uploads/ folder so others see your latest recipes + images

Notes:
- Max upload 5MB; types: jpg/jpeg/png/webp/gif
- Images are saved to /uploads and filename stored in DB
