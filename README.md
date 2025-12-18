# Movie Rating & Review System

A complete CRUD web application for managing movie reviews built with PHP, MySQL, PDO, Bootstrap 5, and Chart.js.

## 🎬 Project Overview

This is a full-featured movie review management system that allows users to:
- Add new movie reviews
- View all reviews in a responsive table
- Edit existing reviews
- Delete reviews with confirmation
- Visualize data with interactive charts

## 🚀 Features

### Core Functionality
- **Create**: Add new movie reviews with validation
- **Read**: Display all reviews with sorting and filtering
- **Update**: Edit existing reviews with pre-filled forms
- **Delete**: Remove reviews with JavaScript confirmation

### Additional Features
- **Rating System**: 1-5 star rating system
- **Genre Management**: Categorize movies by genre
- **Data Visualization**: 
  - Bar chart showing rating distribution
  - Doughnut chart showing genre distribution
- **Responsive Design**: Mobile-friendly Bootstrap 5 interface
- **Security**: PDO prepared statements to prevent SQL injection
- **Validation**: Both client-side and server-side validation

## 📁 Project Structure

```
InternShip_project/
│
├── config/
│   └── database.php          # Database connection configuration
│
├── public/
│   ├── index.php             # Main page (READ operation)
│   ├── add.php               # Add movie page (CREATE operation)
│   ├── edit.php              # Edit movie page (UPDATE operation)
│   └── delete.php            # Delete movie (DELETE operation)
│
├── templates/
│   ├── header.php            # Common header with navigation
│   └── footer.php            # Common footer
│
├── assets/
│   ├── css/
│   │   └── style.css         # Custom stylesheet
│   └── js/
│       └── chart.js          # Chart.js implementation
│
└── sql/
    └── movies.sql            # Database schema and sample data
```

## 🛠️ Tech Stack

- **Backend**: PHP 8+
- **Database**: MySQL
- **DB Access**: PDO with prepared statements
- **Frontend**: HTML5, CSS3
- **Framework**: Bootstrap 5.3.2
- **Charts**: Chart.js 4.4.0
- **Icons**: Bootstrap Icons
- **Server**: XAMPP / Apache

## ⚙️ Installation & Setup

### Prerequisites
- XAMPP (or any Apache + MySQL + PHP environment)
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Edge, etc.)

### Step 1: Install XAMPP
1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install XAMPP and start Apache and MySQL services

### Step 2: Setup Project Files
1. Copy the entire project folder to XAMPP's htdocs directory:
   ```
   C:\xampp\htdocs\InternShip_project\
   ```

### Step 3: Create Database
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click "Import" tab
3. Choose file: `sql/movies.sql`
4. Click "Go" to import the database and sample data

**OR manually create:**
1. Open phpMyAdmin
2. Create a new database named `movie_review_system`
3. Run the SQL script from `sql/movies.sql`

### Step 4: Configure Database Connection
1. Open `config/database.php`
2. Update the following constants if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'movie_review_system');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Default XAMPP password is empty
   ```

### Step 5: Launch Application
1. Ensure Apache and MySQL are running in XAMPP Control Panel
2. Open browser and navigate to:
   ```
   http://localhost/InternShip_project/public/index.php
   ```

## 📊 Database Schema

```sql
CREATE TABLE movies (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    movie_name VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    rating INT(1) NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review TEXT NOT NULL,
    reviewer VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## 🎯 Usage Guide

### Adding a New Movie Review
1. Click "Add New Movie Review" button
2. Fill in the form:
   - Movie Name (required)
   - Genre (select from dropdown)
   - Rating (1-5 stars)
   - Review (minimum 10 characters)
   - Reviewer Name (required)
3. Click "Add Review" button

### Editing a Movie Review
1. Click the yellow "Edit" button (pencil icon) on any movie
2. Modify the fields as needed
3. Click "Update Review" button

### Deleting a Movie Review
1. Click the red "Delete" button (trash icon) on any movie
2. Confirm the deletion in the popup dialog

### Viewing Charts
- Charts automatically update based on current database data
- **Rating Chart**: Shows distribution of movies across 1-5 star ratings
- **Genre Chart**: Shows how many movies belong to each genre

## 🔒 Security Features

1. **PDO Prepared Statements**: Prevents SQL injection attacks
2. **Input Validation**: Both client-side and server-side validation
3. **XSS Protection**: All outputs are sanitized with `htmlspecialchars()`
4. **Error Handling**: Try-catch blocks for database operations
5. **Parameter Binding**: All SQL queries use bound parameters

## 📱 Responsive Design

- Mobile-friendly interface using Bootstrap 5
- Responsive tables and forms
- Optimized for tablets and smartphones
- Touch-friendly buttons and navigation

## 🎨 Customization

### Changing Colors
Edit `assets/css/style.css` and modify the CSS variables:
```css
:root {
    --primary-color: #0d6efd;
    --secondary-color: #6c757d;
    /* Add your custom colors */
}
```

### Adding More Genres
Edit the genre dropdown in `public/add.php` and `public/edit.php`:
```php
<option value="YourGenre">Your Genre</option>
```

### Modifying Chart Types
In `assets/js/chart.js`, change chart types:
- Bar chart → Line chart
- Doughnut chart → Pie chart

## 🐛 Troubleshooting

### Database Connection Error
- Check if MySQL is running in XAMPP
- Verify database credentials in `config/database.php`
- Ensure database `movie_review_system` exists

### 404 Not Found
- Check that project is in correct directory: `htdocs/InternShip_project/`
- Verify Apache is running
- Clear browser cache

### Charts Not Displaying
- Check browser console for JavaScript errors
- Ensure internet connection (CDN links for Chart.js)
- Verify data exists in database

### Styling Issues
- Check if Bootstrap CDN is accessible
- Verify `assets/css/style.css` path is correct
- Clear browser cache

## 📝 Testing the Application

### Test Cases
1. **Create**: Add a movie with all valid data
2. **Create Validation**: Try submitting empty form
3. **Read**: Verify all movies display correctly
4. **Update**: Edit a movie and verify changes
5. **Delete**: Delete a movie and confirm removal
6. **Charts**: Check if charts update after CRUD operations

## 🎓 College Project Submission

This project is submission-ready and includes:
- ✅ Complete CRUD functionality
- ✅ Professional code structure
- ✅ Comprehensive comments
- ✅ Security best practices
- ✅ Responsive design
- ✅ Data visualization
- ✅ Documentation

## 📄 File Descriptions

| File | Purpose |
|------|---------|
| `config/database.php` | Database connection using PDO |
| `public/index.php` | Main page displaying all movies |
| `public/add.php` | Form to add new movie reviews |
| `public/edit.php` | Form to edit existing reviews |
| `public/delete.php` | Script to delete reviews |
| `templates/header.php` | Common header with navigation |
| `templates/footer.php` | Common footer |
| `assets/css/style.css` | Custom CSS styling |
| `assets/js/chart.js` | Chart.js implementation |
| `sql/movies.sql` | Database schema and sample data |

## 🌟 Key Features Breakdown

### PHP Features Used
- PDO (PHP Data Objects)
- Prepared statements
- Try-catch error handling
- Sessions (for messages)
- Form validation
- Superglobals ($_GET, $_POST, $_SERVER)

### MySQL Features
- AUTO_INCREMENT
- Timestamps
- CHECK constraints
- Indexes
- GROUP BY queries
- Aggregate functions (COUNT)

### Frontend Features
- Bootstrap 5 components
- Responsive grid system
- Form validation
- Modal confirmations
- Icon library
- Custom CSS animations

## 📞 Support

For issues or questions:
1. Check the troubleshooting section
2. Verify all installation steps
3. Check browser console for errors
4. Review PHP error logs

## 📜 License

This project is created for educational purposes as part of college internship project submission.

## 👨‍💻 Author

Senior PHP Full-Stack Developer
Date: December 17, 2025

---

**Note**: This is a complete, production-ready CRUD application suitable for college project submission. All code follows best practices and includes comprehensive security measures.
