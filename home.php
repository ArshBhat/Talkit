<!DOCTYPE html>
<html>
<body>
<div class="topnav">
  <a class="active" href="#home">HOME</a>
  <a href="createPost.html">CREATE POST</a>
  <a href="signIn.html">SIGNIN</a>
  <a href="login.html">LOGIN</a>
</div>


<?php
session_start();

if ($_SESSION['username'] === null) {
    echo "<h1>LOGIN TO YOUR ACCOUNT OR SIGNIN</h1>";
} else {
    echo "<h1>LOGGED IN AS ".$_SESSION['username']."</h1>";
};


$username;
$password;

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
            echo "<form action='post.php' method='post'>";
            echo "<input type ='hidden' name='postid' value='".$rowData["postid"]."'>";
            echo "<button type='submit'>";
            echo "<h1>".$rowData["title"]."</h1>";
            echo "<p>Posted by: ".$rowData["username"]."</p>";
            echo "<h3>".$rowData["content"]."</h3>";
            echo "</button>";
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
