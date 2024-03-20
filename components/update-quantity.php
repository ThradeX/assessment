<?php
session_start(); // Start the session

if (isset($_GET['showId']) && isset($_GET['quantity'])) { // Check if showId and quantity parameters are set in the GET request
    $showId = intval($_GET['showId']); // Convert showId to an integer
    $quantity = intval($_GET['quantity']); // Convert quantity to an integer

    // Save the new quantity in the session
    $_SESSION['quantity'][$showId] = $quantity;

    echo 'Quantity updated successfully.'; // Echo success message
} else {
    echo 'Invalid parameters.'; // Echo error message if parameters are missing
}
?>
