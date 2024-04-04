<?php
if (isset($_GET['showId'])) { // Check if show ID is provided via GET request
    $showId = $_GET['showId']; // Retrieve the show ID from the GET request

    if (isset($_COOKIE['cart'])) { // Check if 'cart' cookie exists
        $showIds = json_decode($_COOKIE['cart'], true); // Decode the JSON-encoded cart array from the cookie

        $index = array_search($showId, $showIds); // Search for the show ID in the cart array

        if ($index !== false) {
            unset($showIds[$index]); // Remove the show ID from the cart array

            // Update the 'cart' cookie with the updated cart array
            setcookie('cart', json_encode($showIds), time() + (86400), "/"); // Set the cookie to expire in 24 hours

            echo "Show removed from cart successfully."; // Echo success message
        } else {
            echo "The show was not found in the cart."; // Echo message if the show is not found in the cart
        }
    } else {
        echo "The cart is empty."; // Echo message if the cart is empty
    }
} else {
    echo "Show ID not provided."; // Echo error message if show ID is not provided in the GET request
}
?>