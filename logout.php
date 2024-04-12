<!DOCTYPE html>
<html>

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
} else {
    unset($_SESSION['username']);
    header('Location: home.php');
    exit;
};
?>
</html>
