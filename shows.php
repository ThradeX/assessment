<?php
include('./database/connection.php');

require_once './components/header.php';

$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : ''; // Getting search query from URL and sanitizing it.

$sql = "SELECT * FROM shows WHERE name_show LIKE '%$search%'"; // SQL query to select shows based on search query.

$res = $mysqli->query($sql); // Executing the SQL query.
$qtd = $res->num_rows; // Getting the number of rows returned by the query.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/shows.css">

     <script>
        function addToCart(showId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './components/add-to-cart.php?showId=' + showId, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
<section id="shows">
    <div class="container">
        <div class="filter">
            <form class="form-filter" action="" method="GET">
                <div class="search">
                    <button type="submit">
                        <img src="./icons/search.svg" alt="search">
                    </button>
                    <input type="search" name="search" id="search" value="<?php echo $search; ?>">
                </div>
            </form>

        </div>
        <div class="shows-content">
            <div class="card-list-content">
                <ul class="card-list">
                    <?php
                        if ($qtd > 0) { // Checking if there are shows available
                            while ($row = $res->fetch_object()) { // Iterating through the result set
                                $available = $row->max_tickets - $row->bought; // Calculating available tickets
                                echo ' <li id="show_<?php echo $row->id_show; ?>" class="card"> <!-- Starting a list item -->
                                        <div class="overlay" onclick="addToCart(' . $row->id_show .')"></div> <!-- Adding overlay for click event -->
                                        <div class="card-image">
                                            <img src="' . $row->image_show . '" alt="show cover">
                                        </div>
                                        <div class="card-title">
                                            <h4 class="title">' . $row->name_show . '</h4>
                                            <h4 class="artist">' . $row->name_artist . '</h4>                                                                                           
                                        </div>
                                        <div class="card-description">
                                ';
                                $description_lines = explode("\n", $row->description_show); // Splitting description into lines
                                foreach ($description_lines as $line) { // Iterating through each description line
                                    echo '<p>' . $line . '</p>'; // Displaying each description line
                                }
                                echo '</div> <!-- Closing card-description div -->
                                    <div class="price">
                                        <p>' . $available . ' tickets left</p>
                                        <h4>$' . $row->price . '</h4>
                                    </div>
                                    <div class="overlay-text">ADD TO CART</div>
                                </li>';
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    </section>
</body>
</html>

<?php
require_once './components/footer.php';
?>