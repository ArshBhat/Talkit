<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>viewpost</title>
        <link rel="stylesheet" href="styling.css">
    </head>
<body>
<?php
session_start();

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
    
    $sql = "SELECT * FROM posts";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($rowData = mysqli_fetch_assoc($result)) {
            echo "<h1>".$rowData["title"]."</h1>";
            echo "<p>Posted by: ".$rowData["username"]."</p>";
            echo "<h3>".$rowData["content"]."</h3>";

            echo "<form action='deletepost.php' method='post'>";
            echo "<input type ='hidden' name='postid' value='".$rowData["postid"]."'>";
            echo "<button type='submit' class='btn'>Delete Post</button>";
            echo "</form>";
            echo "<br>";
        }
    } else {
        echo "No posts found";
    }
    mysqli_close($connection);
}
?>



</body>
</html>
