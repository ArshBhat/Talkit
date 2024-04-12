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

$host = "localhost";
$database = "lab9";
$user = "root";
$password = "";

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
        $postid = $_POST['postid'];
        if (isset($postid)) {
            $sql = "DELETE FROM posts WHERE postid = '$postid'";
            mysqli_query($connection, $sql);
            mysqli_close($connection);
            header('Location: viewpost.php');
            exit; 
        } else {
            echo "<p><a href='viewpost.php'>Parameters not set, Return to home page</a></p>";
        };
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='viewpost.php'>Bad Data, Return to home page</a></p>";
    }

    
}
?>
</body>
</html>
