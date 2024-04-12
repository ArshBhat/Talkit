<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
<?php
session_start();

$postid;
$comment;

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
        $postid = $_SESSION['postidcurrent'];
        $comment = $_POST['comment'];
        if (isset($postid) && isset($comment)) {
            $sql = "INSERT INTO comments VALUES ('$postid','$comment')";
            
            $isExecuted = mysqli_query($connection, $sql);

            if ($isExecuted) {
                echo "<p>Your comment has been posted</p>";    
                echo "<p><a href='home.php'>Return to home page</a></p>";    
            } else {
                echo "<p>Error while posting comment</p>";
                echo "<p><a href='post.php'>Return to post page</a></p>";
            };


            mysqli_close($connection);
        } else {
            echo "<p><a href='post.php'>Parameters not set, Return to post page</a></p>";
        };
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='post.php'>Bad Data, Return to post page</a></p>";
    }

    
}
?>
</body>
</html>
