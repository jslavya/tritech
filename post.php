


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url("post.jpeg");
            background: linear-gradient(135deg, #DAD7CD, #A3B18A);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .post-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            width: 500px;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #3A5A40;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 1rem;
            border: 2px solid #588157;
            border-radius: 10px;
            resize: none;
            font-size: 1rem;
            outline: none;
            background-color: #F0F2F5;
            color: #344E41;
            transition: 0.3s;
        }

        textarea:focus {
            background-color: white;
            border-color: #3A5A40;
            box-shadow: 0 0 8px rgba(58, 90, 64, 0.5);
        }

        button {
            margin-top: 1.5rem;
            padding: 0.8rem 2rem;
            background: #3A5A40;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: bold;
            transition: 0.3s;
        }

        button:hover {
            background: #588157;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="post-container">
        <h2>Create a Post</h2>
        <form action="storePost.php" method="post">
            <textarea name="postContent" placeholder="What's on your mind?" required></textarea>
            <button type="submit" onclick="window.location.href='home.html'">Post</button>
        </form>
    </div>
</body>
</html>