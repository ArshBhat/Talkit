<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    <header class="topnav">
        <a class="active" href="#home">HOME</a>
        <a href="createPost.html">CREATE POST</a>
        <a href="signIn.html">SIGNIN</a>
        <a href="login.php">LOGIN</a>
    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        echo "<h1>LOGIN TO YOUR ACCOUNT OR SIGNUP</h1>";
    } else {
        echo "<h1>LOGGED IN AS ".$_SESSION['username']."</h1>";
        echo "<br>";
        echo "<a href='editprofile.html'>EDIT YOUR PROFILE</a>";
        echo "<br>";
        echo "<a href='viewprofile.php'>VIEW YOUR PROFILE</a>";
        echo "<br>";
        echo "<a href='logout.php'>LOGOUT</a>";
        echo "<br>";
        
    };
    echo "</header><main>";
    $username;
    $password;

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
        
        $sql = "SELECT * FROM posts";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($rowData = mysqli_fetch_assoc($result)) {
                echo "<form action='post.php' method='post'>";
                echo "<input type ='hidden' name='postid' value='".$rowData["postid"]."'>";
                echo "<button type='submit' class='post'>";
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
    </main>
</body>
</html>