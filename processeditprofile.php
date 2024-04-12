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

$firstname;
$lastname;
$username;
$email;
$password;
$imageFileType;
$target_dir;
$target_file;
$uploadOk;
$userID; 

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
    //file upload code
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["userImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["userImage"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["userImage"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
    if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["userImage"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    }

    // end of file upload

    $username = $_SESSION['username'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        if (isset($firstname) && isset($lastname) && isset($email) &&isset($password)) {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $results = mysqli_query($connection, $sql);

            $sql2 = "UPDATE users SET firstName = '$firstname', lastName = '$lastname', email = '$email', password = '$password' WHERE username = '$username'";

            if (mysqli_num_rows($results) > 0) {
                mysqli_query($connection, $sql2);
                echo "<p>The profile for the user $firstname has been updated</p>";
                $sql3 = "SELECT userID FROM users WHERE username = '$username'";
                $results = mysqli_query($connection, $sql3);
                $user = mysqli_fetch_assoc($results);
                $userID = $user['userID'];

                $imagedata = file_get_contents($_FILES['userImage']['tmp_name']);
                $sql = "UPDATE userImages SET contentType = ?, image = ? WHERE userID = ?";
                $stmt = mysqli_stmt_init($connection); 
                mysqli_stmt_prepare($stmt, $sql); 
                $null = NULL;
                mysqli_stmt_bind_param($stmt, "sbi", $imageFileType, $null, $userID);
                mysqli_stmt_send_long_data($stmt, 1, $imagedata);
                $result = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
                mysqli_stmt_close($stmt); 
            } else {
                echo "<p>User does not exist with this username</p>";
                echo "<p><a href='editprofile.html'>Return to user entry</a></p>";                
            };


            mysqli_free_result($results);
            mysqli_close($connection);
        } else {
            echo "<p><a href='editprofile.html'>Parameters not set, Return to user entry</a></p>";
        };
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='editprofile.html'>Bad Data, Return to user entry</a></p>";
    }

    
}
?>
</body>
</html>
