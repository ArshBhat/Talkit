<!DOCTYPE html>
<html>

<?php

$username;
$oldpassword;
$newpassword;

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
        $username = $_POST['username'];
        $oldpassword = md5($_POST['oldpassword']);
        $newpassword = md5($_POST['newpassword']);
        if (isset($username) &&  isset($oldpassword) && isset($newpassword)) {
            $sql = "SELECT * FROM users WHERE username = '$username' and password = '$oldpassword'";
            $results = mysqli_query($connection, $sql);

            $sql2 = "UPDATE users SET password = '$newpassword' WHERE username = '$username'";

            if (mysqli_num_rows($results) > 0) {
                mysqli_query($connection, $sql2);
                echo "<p>users password has been updated</p>";        
            } else {
                echo "<p>username and/or password are invalid</p>";
                echo "<p><a href='changePassword.html'>Return to password change</a></p>";
            };

            mysqli_free_result($results);
            mysqli_close($connection);
        }else {
            echo "<p><a href='changePassword.html'>Parameters not set, Return to user entry</a></p>";
        };

    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='changePassword.html'>Bad Data, Return to user entry</a></p>";
    }

    
}
?>
</html>
