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
$username;

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
        if (isset($username)) {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $results = mysqli_query($connection, $sql);

            if (mysqli_num_rows($results) == 1) {
                echo "<p>user exits</p>";
                $user = mysqli_fetch_assoc($results);
                echo "<fieldset>
                <legend>User: $username</legend>
                <table>
                    <tr>
                        <td>
                        First Name:
                        </td>
                        <td>"
                        .$user['firstName'].
                        "</td>
                    </tr>
                    <tr>
                        <td>
                        Last Name:
                        </td>
                        <td>"
                        .$user['lastName'].
                        "</td>
                    </tr>
                    <tr>
                        <td>
                        Email:
                        </td>
                        <td>"
                        .$user['email'].
                        "</td>
                    </tr>
                    <tr>
                        <td>
                        userID:
                        </td>
                        <td>"
                        .$user['userID'].
                        "</td>
                    </tr>
                </table>
                </fieldset>";
                $userID = $user['userID'];
                $sql = "SELECT contentType, image FROM userImages where userID=?";
                $stmt = mysqli_stmt_init($connection);
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "i", $userID);
                $result = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
                mysqli_stmt_bind_result($stmt, $type, $image); 
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
                echo '<img src="data:image/'.$type.';base64,'.base64_encode($image).'"/>';
                        
            } else {
                echo "<p>username is invalid</p>";
                echo "<p><a href='finduser.html'>Return to find user page</a></p>";
            };


            mysqli_free_result($results);
            mysqli_close($connection);
        } else {
            echo "<p><a href='finduser.html'>Parameters not set, Return to find user page</a></p>";
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='finduser.html'>Bad Data, Return to user search</a></p>";
    }

    
}
?>
</body>
</html>
