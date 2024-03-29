<!DOCTYPE html>
<html>

<?php
session_start();

$postid;

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
        $postid = $_POST['postid'];
        if (isset($postid)) {
            $sql = "SELECT * FROM posts WHERE postid = '$postid'";
            $results = mysqli_query($connection, $sql);

            if (mysqli_num_rows($results) > 0) {
                $rowData = mysqli_fetch_assoc($results);
                echo "<h1>".$rowData["title"]."</h1>";
                echo "<p>Posted by: ".$rowData["username"]."</p>";
                echo "<h3>".$rowData["content"]."</h3>"; 
                $_SESSION['postidcurrent'] = $rowData["postid"];
                echo "<form action='comment.html' method='post'>";
                // echo "<input type ='hidden' name='postid' value='".$rowData["postid"]."'>";
                echo "<button type='submit'>COMMENT ON THIS POST</button>";
                echo "</form>";   
                
                $sql2 = "SELECT * FROM comments WHERE postid = '$postid'";
                $results2 = mysqli_query($connection, $sql2);
                if (mysqli_num_rows($results2) > 0) {
                    while($comment = mysqli_fetch_assoc($results2)) {
                        echo "<hr>";
                        echo "<p>".$comment["comment"]."</p>";                        
                    }
                } else {
                    echo "No Comments yet";
                }
                
            } else {
                echo "<p>error</p>";
                echo "<p><a href='home.php'>Return to home page</a></p>";
            };


            mysqli_free_result($results);
            mysqli_close($connection);
        } else {
            echo "<p><a href='home.php'>Parameters not set, Return to home page</a></p>";
        };
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // CHECKING FOR BAD DATA
        echo "<p><a href='home.php'>Bad Data, Return to home page</a></p>";
    }

    
}
?>
</html>
