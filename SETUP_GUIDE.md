# Quick Setup Guide - Movie Rating & Review System

## ⚡ Fast Track Installation (5 Minutes)

### Step 1: Start XAMPP (1 minute)
1. Open XAMPP Control Panel
2. Click **Start** for Apache
3. Click **Start** for MySQL
4. Wait for green status indicators

### Step 2: Import Database (2 minutes)
1. Open browser: http://localhost/phpmyadmin
2. Click **New** in left sidebar
3. Database name: `movie_review_system`
4. Click **Create**
5. Select the new database
6. Click **Import** tab
7. Click **Choose File** → Navigate to `sql/movies.sql`
8. Click **Go** at bottom
9. Wait for "Import has been successfully finished" message

### Step 3: Verify Database Connection (30 seconds)
1. Open `config/database.php` in code editor
2. Check these settings match your XAMPP:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'movie_review_system');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Empty for default XAMPP
   ```

### Step 4: Launch Application (30 seconds)
1. Open browser
2. Navigate to: http://localhost/InternShip_project/public/index.php
3. You should see the Movie Rating & Review System homepage!

### Step 5: Test the Application (1 minute)
✅ **READ**: You should see 15 sample movie reviews
✅ **CREATE**: Click "Add New Movie Review" button
✅ **UPDATE**: Click yellow pencil icon on any movie
✅ **DELETE**: Click red trash icon (will ask for confirmation)
✅ **CHARTS**: Scroll down to see rating and genre distribution charts

---

## 🎯 Direct Access URLs

After setup, bookmark these URLs:

- **Home Page**: http://localhost/InternShip_project/public/index.php
- **Add Movie**: http://localhost/InternShip_project/public/add.php
- **phpMyAdmin**: http://localhost/phpmyadmin

---

## ⚠️ Common Issues & Quick Fixes

### Issue: "Database connection failed"
**Fix**: 
1. Check MySQL is running in XAMPP (green indicator)
2. Verify database name is `movie_review_system`
3. Check username is `root` with empty password

### Issue: "Access denied for user 'root'"
**Fix**: 
1. Open phpMyAdmin
2. Go to User accounts
3. Check root user exists with no password
4. Or update password in `config/database.php`

### Issue: Page shows PHP code instead of rendering
**Fix**: 
1. Check Apache is running in XAMPP
2. Access via http://localhost (not file://)
3. Ensure .php file extension is present

### Issue: Charts not showing
**Fix**: 
1. Check internet connection (needs CDN for Chart.js)
2. Check browser console for errors (F12)
3. Verify database has data

### Issue: Styles not loading
**Fix**: 
1. Check path: `assets/css/style.css` exists
2. Clear browser cache (Ctrl+F5)
3. Check internet connection (needs CDN for Bootstrap)

---

## 📊 Sample Data Included

The SQL file includes **15 pre-loaded movie reviews** covering:
- 5 different ratings (1-5 stars)
- 12 different genres
- Variety of popular movies
- Multiple reviewers

This allows immediate testing without adding data manually!

---

## 🧪 Quick Test Checklist

Before submitting or presenting:

**CRUD Operations:**
- [ ] Add a new movie review
- [ ] View all movies in table
- [ ] Edit an existing review
- [ ] Delete a review (with confirmation)

**Validation:**
- [ ] Try submitting empty form (should show errors)
- [ ] Try rating outside 1-5 range (should fail)
- [ ] Check minimum review length (10 chars)

**UI/UX:**
- [ ] Check responsive design on mobile
- [ ] Verify navigation links work
- [ ] Test success/error messages
- [ ] Confirm alerts are dismissible

**Charts:**
- [ ] Rating distribution chart displays
- [ ] Genre distribution chart displays
- [ ] Charts update after CRUD operations
- [ ] Hover tooltips work

**Security:**
- [ ] Check for SQL injection protection
- [ ] Verify XSS protection (HTML escaping)
- [ ] Test with invalid movie ID in URL
- [ ] Check error handling

---

## 🎓 Project Demonstration Tips

### For College Presentation:

1. **Start with Homepage**
   - Show the clean, professional interface
   - Highlight the movie count badge
   - Explain the table structure

2. **Demonstrate CREATE**
   - Add a new movie live
   - Show validation errors (submit empty)
   - Show success message after adding

3. **Demonstrate READ**
   - Sort by date
   - Show all fields displayed
   - Explain star rating system

4. **Demonstrate UPDATE**
   - Edit an existing movie
   - Show pre-filled form
   - Update and show success

5. **Demonstrate DELETE**
   - Delete with confirmation dialog
   - Show success message
   - Verify removed from list

6. **Showcase Charts**
   - Explain rating distribution
   - Explain genre distribution
   - Show dynamic updates

7. **Technical Highlights**
   - PDO with prepared statements
   - Server & client-side validation
   - Bootstrap responsive design
   - Chart.js visualization
   - Modular code structure

---

## 💡 Pro Tips

1. **Backup Database**: Export DB before demo: phpMyAdmin → Export
2. **Test Before Demo**: Run through all features 30 mins before
3. **Clear Browser Cache**: Ctrl+F5 before starting presentation
4. **Prepare Talking Points**: Explain security features, PDO benefits
5. **Show Code**: Have key files open in editor to show code quality

---

## 📞 Verification Commands

Run these in phpMyAdmin SQL tab to verify:

```sql
-- Check total movies
SELECT COUNT(*) FROM movies;

-- Check ratings distribution
SELECT rating, COUNT(*) as count FROM movies GROUP BY rating;

-- Check genres
SELECT DISTINCT genre FROM movies ORDER BY genre;

-- View latest additions
SELECT * FROM movies ORDER BY created_at DESC LIMIT 5;
```

Expected results:
- Total movies: 15
- Ratings: Mix of 1-5 stars
- Genres: 12 different genres
- Latest: Sorted by date

---

## ✅ Ready to Submit!

Your project includes:
- ✅ Complete CRUD functionality
- ✅ Professional UI with Bootstrap 5
- ✅ Data visualization with Chart.js
- ✅ Security (PDO, validation, XSS protection)
- ✅ Responsive design
- ✅ Well-commented code
- ✅ Modular structure
- ✅ Sample data for testing
- ✅ Complete documentation

**Total Setup Time**: ~5 minutes
**Demonstration Time**: ~10-15 minutes
**Code Quality**: Production-ready

Good luck with your submission! 🎉
