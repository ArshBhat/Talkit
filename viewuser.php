<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>viewuser</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    


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
    
    $sql = "SELECT * FROM users";
    $results = mysqli_query($connection, $sql);

    if (mysqli_num_rows($results) > 0) {
        while ($user = mysqli_fetch_assoc($results)) {
            echo "<fieldset>
        <legend>User: ".$user['username']."</legend>
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

        echo "<form action='deleteuser.php' method='post'>";
        echo "<input type ='hidden' name='username' value='".$user["username"]."'>";
        echo "<button type='submit'>";
        echo "<p>Delete User</p>";
        echo "</button>";
        echo "</form>";
        echo "<br>";

        $userID = $user['userID'];
        $sql = "SELECT contentType, image FROM userImages where userID=?";
        $stmt = mysqli_stmt_init($connection);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        $result = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
        mysqli_stmt_bind_result($stmt, $type, $image); 
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        echo '<img class="img" src="data:image/'.$type.';base64,'.base64_encode($image).'"/>';
        }                    
    } else {
        echo "<p>username is invalid</p>";
        echo "<p><a href='finduser.html'>Return to find user page</a></p>";
    };


    mysqli_free_result($results);
    mysqli_close($connection);

    
}
?>
</body>
</html>
