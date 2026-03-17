# ⚡ AptCode – Setup Guide

**AptCode** is a full-stack student placement preparation platform built with HTML, CSS, JavaScript, PHP, and MySQL (XAMPP).

---

## 📁 Folder Structure

```
aptcode/
├── index.html               ← Main website (entry point)
├── database.sql             ← Database setup script
├── README.md                ← This file
│
├── css/
│   └── style.css            ← All styles
│
├── js/
│   ├── main.js              ← Main app logic
│   └── games.js             ← Interactive games
│
├── php/
│   ├── auth.php             ← Login / Register / Logout
│   └── questions.php        ← Questions API & scores
│
└── includes/
    └── config.php           ← Database config & helpers
```

---

## 🚀 Installation Steps

### Step 1 – Install XAMPP
1. Download XAMPP from: https://www.apachefriends.org
2. Install and open **XAMPP Control Panel**
3. Start **Apache** and **MySQL**

### Step 2 – Copy Project Files
1. Navigate to your XAMPP installation folder:
   - Windows: `C:\xampp\htdocs\`
   - macOS: `/Applications/XAMPP/htdocs/`
   - Linux: `/opt/lampp/htdocs/`
2. Create a folder named `aptcode`
3. Copy **all project files** into `C:\xampp\htdocs\aptcode\`

### Step 3 – Set Up the Database
1. Open your browser and go to: http://localhost/phpmyadmin
2. Click **"New"** in the left sidebar to create a new database
   — OR just import the SQL file (it creates the DB automatically)
3. Click on the **"Import"** tab at the top
4. Click **"Choose File"** and select `aptcode/database.sql`
5. Click **"Go"** to import
6. You should see: `AptCode database setup complete!`

### Step 4 – Open the Website
Visit: **http://localhost/aptcode/**

---

## 🔑 Demo Account
After database setup, a demo account is available:
- **Username:** `demo_user`
- **Password:** `password`

---

## ⚙️ Configuration

If your MySQL setup uses a different username/password, edit:
**`includes/config.php`**

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');     // Your MySQL username
define('DB_PASS', '');         // Your MySQL password
define('DB_NAME', 'aptcode_db');
```

---

## 🎯 Features

| Feature | Description |
|---------|-------------|
| 🧠 Aptitude | Logical, Quantitative, Verbal, Puzzles with explanations |
| 💻 Coding | Easy/Medium/Hard problems with in-browser JS execution |
| 🎮 Games | Memory Match, Number Sequence, Math Blitz, Typing Speed |
| 👤 Auth | Register, Login, Logout with sessions |
| 📊 Dashboard | Scores, rank, activity history |
| 🏆 Leaderboard | Top 20 users ranked by score |
| 🔥 Daily | Fresh challenge daily + 50-point bonus |
| 📱 Responsive | Works on mobile, tablet, and desktop |

---

## 🛠️ Troubleshooting

**"Database connection failed"**
→ Make sure MySQL is running in XAMPP Control Panel

**"Page not found"**
→ Make sure Apache is running and files are in `/htdocs/aptcode/`

**Questions not loading**
→ Check that you imported `database.sql` in phpMyAdmin

**PHP errors showing**
→ Make sure PHP version is 7.4 or higher (XAMPP 8.x recommended)

---

## 📦 Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Backend:** PHP 7.4+
- **Database:** MySQL via XAMPP
- **Fonts:** Syne, Space Grotesk, JetBrains Mono (Google Fonts)
- **No external JS frameworks** — pure vanilla JS!

---

## 🏗️ Adding More Questions

To add more aptitude questions, run SQL like:
```sql
USE aptcode_db;
INSERT INTO aptitude_questions (category, difficulty, question, option_a, option_b, option_c, option_d, correct_option, explanation, points)
VALUES ('logical', 'easy', 'Your question here?', 'Option A', 'Option B', 'Option C', 'Option D', 'A', 'Explanation here.', 10);
```

---

Built with ❤️ for students preparing for campus placements.
