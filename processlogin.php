<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit;
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
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        if (isset($username) && isset($password)) {
            if ($username == 'admin' && $password == md5('admin@123')) {
                $_SESSION['username'] = $username;
                header('Location: admin.html');
                exit;
            } else {
                $sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
                $results = mysqli_query($connection, $sql);

                if (mysqli_num_rows($results) == 1) {
                    $_SESSION['username'] = $username;
                    header('Location: home.php');
                    exit;       
                } else {
                    echo "<p>username and/or password are invalid</p>";
                    echo "<p><a href='login.php'>Return to login page</a></p>";
                    // header('Location: login.php');
                    // exit;
                };
            };   


            mysqli_free_result($results);
            mysqli_close($connection);
        } else {
            // echo "<p><a href='login.php'>Parameters not set, Return to login page</a></p>";
            header('Location: login.php');
            exit;
        };
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        // echo "<p><a href='login.php'>Bad Data, Return to login page</a></p>";
        header('Location: login.php');
        exit;
    }

    
}
?>

