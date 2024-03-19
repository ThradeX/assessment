<?php
    if (!isset($_SESSION)) { // Start session if not already started
        session_start();
    }

    if(isset($_GET['logout'])) { // Logout functionality: If logout parameter is present in the URL, destroy the session and redirect to index.php
        session_destroy();
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside Showdown</title>
    <link rel="stylesheet" href="./style/header.css">
    <link rel="stylesheet" href="./style/footer.css">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="<?= 'assets/css/' . $pageStyle ?>">
</head>

<body>
    <header class="app-header">
      <div class="header-content">
        <img class="logo" src="./images/logo.png" alt="Logo MV" />
        <nav class="nav-links">
          <a href="./" >
            HOME
          </a>
          <a href="./shows.php">
            SHOWS
          </a>
          <?php   
            if(!isset($_SESSION)) {
              session_start();
            }

            if(isset($_SESSION['id'])) { // Check if user is logged in
              // If logged in, display cart and logout links
              echo '<div class="user">
                <a href="checkout.php">CART</a>
                <a href="?logout">LOGOUT</a>
              </div">';
            } else { // If not logged in, display login link
              echo '<a href="./login.php">LOGIN</a>';
            }
          ?>
        </nav>
      </div>
    </header>