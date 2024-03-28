<!DOCTYPE html>
<html>

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
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        if (isset($username) && isset($password)) {
            $sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
            $results = mysqli_query($connection, $sql);

            if (mysqli_num_rows($results) == 1) {
                $_SESSION['username'] = $username;
                echo "<p>user has a valid account</p>";        
            } else {
                echo "<p>username and/or password are invalid</p>";
                echo "<p><a href='login.html'>Return to login page</a></p>";
            };


            mysqli_free_result($results);
            mysqli_close($connection);
        } else {
            echo "<p><a href='login.html'>Parameters not set, Return to login page</a></p>";
        };
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='login.html'>Bad Data, Return to login page</a></p>";
    }

    
}
?>
</html>
