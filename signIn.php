<!DOCTYPE html>
<html>

<div class="topnav">
  <a href="home.php">HOME</a>
  <a href="createPost.html">CREATE POST</a>
  <a href="signIn.html">SIGNIN</a>
  <a href="login.html">LOGIN</a>
</div>

<?php

$firstname;
$lastname;
$username;
$email;
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
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        if (isset($firstname) && isset($lastname) && isset($username) && isset($email) &&isset($password)) {
            $sql = "SELECT * FROM users WHERE username = '$username' or email = '$email'";
            $results = mysqli_query($connection, $sql);

            $sql2 = "INSERT INTO users VALUES ('$username','$firstname','$lastname','$email','$password')";

            if (mysqli_num_rows($results) > 0) {
                echo "<p>User already exists with this name and/or email</p>";
                echo "<p><a href='signIn.html'>Return to user entry</a></p>";
            } else {
                mysqli_query($connection, $sql2);
                echo "<p>An account for the user $firstname has been created</p>";
            };


            mysqli_free_result($results);
            mysqli_close($connection);
        } else {
            echo "<p><a href='signIn.html'>Parameters not set, Return to user entry</a></p>";
        };
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='signIn.html'>Bad Data, Return to user entry</a></p>";
    }

    
}
?>
</html>
