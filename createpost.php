<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>

<div class="topnav">
  <a href="home.php">HOME</a>
  <a href="createPost.html">CREATE POST</a>
  <a href="signIn.html">SIGNIN</a>
  <a href="login.html">LOGIN</a>
</div>

<?php
session_start();

$username;
$password;

$host = "localhost";
$database = "db_40202400";
$user = "40202400";
$password = "40202400";

$connection = mysqli_connect($host, $user, $password, $database);

$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
    //good connection, so do you thing
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_SESSION['username'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        if (isset($username) && isset($title) && isset($content)) {
            $sql = "INSERT INTO posts (username, title, content) VALUES ('$username','$title','$content')";
            $isExecuted = mysqli_query($connection, $sql);

            if ($isExecuted) {
                echo "<p>A new post has been created</p>";        
            } else {
                echo "<p>Post NOT CREATED!!!</p>";
                echo "<p><a href='createPost.html'>Return to create post page</a></p>";
            };


            mysqli_close($connection);
        } else {
            echo "<p><a href='createPost.html'>Parameters not set, Return to create post page</a></p>";
        };
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='createPost.html'>Bad Data, Return to create post page</a></p>";
    }

    
}
?>
</body>
</html>
