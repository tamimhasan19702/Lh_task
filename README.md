<!-- @format -->

# Lemon Hive Blog - PHP Intern Task

![Home Page](https://github.com/tamimhasan19702/Lh_task/blob/main/public/assets/images/preview_1.png)

A simple blog admin panel built with PHP, Tailwind CSS, and MySQL.

## 📌 Features

![Login Page](https://github.com/tamimhasan19702/Lh_task/blob/main/public/assets/images/preview_2.png)
![Admin Panel](https://github.com/tamimhasan19702/Lh_task/blob/main/public/assets/images/preview_3.png)
![create post](https://github.com/tamimhasan19702/Lh_task/blob/main/public/assets/images/preview_4.png)

✅ Create, edit, and delete blog posts  
✅ Upload featured images  
✅ Responsive design (mobile + desktop views)  
✅ AJAX-based editing and deletion  
✅ Settings page to configure "posts per page"  
✅ Flash messages for success/failure feedback

## 📁 Folder Structure

```
├── admin/
│   ├── dashboard.php
│   ├── create-post.php
│   ├── edit-post.php
│   ├── update-post.php
│   └── settings.php
├── public/
│   └── post.php # Public view of a single post
├── assets/
│   ├── css/ # Tailwind and custom styles
│   └── js/ # JavaScript for dashboard interactivity
├── models/
│   └── Blog.php # Blog model with DB logic
├── helpers/
│   └── ConstantHelper.php
├── utils/
│   └── Database.php # Singleton database connection
├── includes/
│   └── header.php # Reusable header template
└── vendor/ # Composer dependencies
```

## ⚙️ How to Run

### 1. Clone the Project

```bash
git clone https://github.com/tamimhasan19702/Lh_task.git
cd Lh_task
```

2. **Install Dependencies**

   Make sure you have Composer installed:

3. **Setup Database**

```bash
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    posts_per_page INT DEFAULT 9
);

```

4. **Update your database credentials in utils/Database.php.**

🚀 Usage
Login to the admin panel admin/login.php [use: username: lemon; password: lemon]

Go to Dashboard admin/dashboard.php to:

- View all blog posts
- Create, edit or delete posts
- Change settings like posts per page

View public blog post:
Visit post.php?id=1 to see individual post.

## Technologies Used

- PHP - Backend logic and database interaction
- Tailwind CSS - Utility-first styling
- JavaScript - Modal handling and AJAX updates
- MySQL - Store blog data
- Material Icons - UI icons

## preview
