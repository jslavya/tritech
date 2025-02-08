<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
    <link rel="stylesheet" href="signin.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <header class="header">
                <h2>TALK IT</h2>
                <nav>
                    <a href="#">Home</a>
                    <a href="#">Join</a>
                </nav>
            </header>
            <div class="form">
                <h2>Create new account.</h2>
               
                <p class="login-text">Already A Member? <a href="login.html">Log In</a></p>
                <form method='POST'>
                <div class='alert alert-warning'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        </div>
                    <div class="input-box">
                        <input type="text" placeholder="First Name" required>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Last Name" required>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="Email" required>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" required>
                    </div>
                   <button type="button" class="btn btn-primary" onclick="window.location.href='home.html'">GET STARTED</button>

                    <button class="change-method" type="button">Change method</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php

// Database connection settings
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "social_platform";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS social_platform";
if ($conn->query($sql) === TRUE) {
    // Database created successfully or already exists
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database to work with
$conn->select_db("social_platform");

// Create the posts table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    // Table created successfully or already exists
} else {
    echo "Error creating table: " . $conn->error;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and sanitize it
    $postContent = htmlspecialchars(trim($_POST['postContent']), ENT_QUOTES, 'UTF-8');

    // Validate input (e.g., check length)
    if (strlen($postContent) > 2000) {
        echo "Error: Post content is too long.";
    } else {
        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO posts (content) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $postContent);

        if ($stmt->execute() === TRUE) {
            echo "Post created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Retrieve posts from the database
$sql = "SELECT id, content, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            color: #1b5e20;
            font-family: Arial, sans-serif;
            background-image: url("home2.jpeg");
            background-repeat: repeat-x;
            background-size: calc(100vw / 3) calc((100vw / 3) * (842 / 474));
            background-position: top left;
        }

        .navbar {
            background-color: #344e41;
            color: white;
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-toggle {
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            color: white;
        }

        .container {
            display: flex;
            margin-top: 60px;
        }

        .sidebar {
            width: 250px;
            background-color: #dad7cd;
            height: calc(100vh - 60px);
            position: fixed;
            padding: 1rem;
            transform: translateX(-250px);
            transition: transform 0.3s ease;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.8rem;
            color: #333d29;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }

        .sidebar-link i {
            margin-right: 10px;
            width: 20px;
        }

        .sidebar-link:hover {
            background-color: #81c784;
        }

        .main-content {
            margin-left: 0;
            padding: 2rem;
            width: 100%;
            transition: margin-left 0.3s ease;
        }

        .main-content.shifted {
            margin-left: 250px;
        }

        .post {
            background-color: #b5c99a;
            opacity: 0.8;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #81c784;
            margin-right: 10px;
        }

        .post-content {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
            border-left: 3px solid #6c584c;
            padding-left: 1rem;
        }

        .post-actions {
            display: flex;
            gap: 1rem;
            padding-top: 0.5rem;
            border-top: 1px solid #eee;
        }

        .action-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border: none;
            background: none;
            cursor: pointer;
            color: #1b5e20;
        }

        .action-button:hover {
            color: #31572c;
        }

        .profile-section {
            display: none;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #132a13;
            margin-right: 1rem;
        }

        .profile-info h2 {
            margin-bottom: 0.5rem;
        }

        .profile-posts {
            margin-top: 2rem;
        }

        .date-badge {
            background-color: #31572c;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: inline-block;
        }

        /* Chatbot Icon Styles */
        .chatbot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50; /* Green */
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            text-align: center;
            line-height: 60px;
            font-size: 2rem;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease;
            z-index: 999; /* Ensure it's always on top */
        }

        .chatbot-icon:hover {
            background-color: #3e8e41;
        }

        /* New Post Form Styles */
        .new-post-form {
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .new-post-form textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .new-post-form button {
            background-color: #4CAF50;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Post Display Styles */
        .post-list {
            margin-top: 2rem;
        }

        .post-list .post {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .post-list .post .post-content {
        color: black;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="logo">Social Platform</div>
        <div></div>
    </nav>

    <div class="container">
        <div class="sidebar">
            <a href="#" class="sidebar-link" onclick="showHome()">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="post.html" class="sidebar-link">
                <i class="fas fa-plus"></i> Create Post
            </a>
            <a href="#" class="sidebar-link" onclick="showProfile()">
                <i class="fas fa-user"></i> Profile
            </a>
        </div>

        <div class="main-content" id="mainContent">
             <!-- New Post Form -->
            <div class="new-post-form">
                <h3>Create a New Post</h3>
                <form method="post" action="">
                    <textarea name="postContent" placeholder="What's on your mind?" required></textarea>
                    <button type="submit">Post</button>
                </form>
            </div>

            <!-- Display Existing Posts -->
            <div class="post-list">
                <h3>Existing Posts</h3>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='post'>";
                        echo "<div class='post-content'>" . $row["content"] . "</div>";
                        echo "<small>Posted on: " . $row["created_at"] . "</small>";
                        echo "</div>";
                    }
                } else {
                    echo "No posts yet.";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('shifted');
        }

        function handleLike(button) {
            button.classList.toggle('liked');
            const icon = button.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            icon.style.color = icon.classList.contains('fas') ? '#4267B2' : '#65676b';
        }

        function handleComment(button) {
            const post = button.closest('.post');
            const existingComments = post.querySelector('.comments');

            if (!existingComments) {
                const commentsSection = document.createElement('div');
                commentsSection.className = 'comments';
                commentsSection.innerHTML = `
                    <div style="margin-top: 1rem;">
                        <textarea placeholder="Write a comment..."
                                  style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ddd;">
                        </textarea>
                        <button style="margin-top: 0.5rem; padding: 0.5rem 1rem; background: #4267B2; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            Post Comment
                        </button>
                    </div>
                `;
                post.appendChild(commentsSection);
            }
        }

        function showProfile() {
            document.getElementById('posts-section').style.display = 'none';
            document.getElementById('profile-section').style.display = 'block';
        }

        function showHome() {
            document.getElementById('posts-section').style.display = 'block';
            document.getElementById('profile-section').style.display = 'none';
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>

