<!DOCTYPE html>
<html>

<?php
$username;

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
                </table>
                </fieldset>";
                        
            } else {
                echo "<p>username is invalid</p>";
                echo "<p><a href='findUser.html'>Return to find user page</a></p>";
            };


            mysqli_free_result($results);
            mysqli_close($connection);
        } else {
            echo "<p><a href='findUser.html'>Parameters not set, Return to find user page</a></p>";
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='findUser.html'>Bad Data, Return to user search</a></p>";
    }

    
}
?>
</html>
