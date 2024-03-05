<?php
include('./database/connection.php');

require_once './components/header.php';

// function addToCart($showId) {
//     echo "add to cart";
//     if (!isset($_COOKIE['cart'])) {
//         $cart = array();
//     } else {
//         $cart = json_decode($_COOKIE['cart'], true);
//     }
//     $cart[] = $showId;
//     setcookie('cart', json_encode($cart), time() + (86400), "/");
// }

$results_per_page = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$start_index = ($page - 1) * $results_per_page;

$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';

$order = isset($_GET['order']) ? $mysqli->real_escape_string($_GET['order']) : 'name';

$filter = isset($_GET['others']) ? $mysqli->real_escape_string($_GET['others']) : 'all';

$sql = "SELECT * FROM shows WHERE name_show LIKE '%$search'";

$res = $mysqli->query($sql);
$qtdShows = $res->num_rows;

$sql = "SELECT * FROM shows WHERE name_show LIKE '%$search'";

$sql .= " LIMIT $start_index, $results_per_page";
$res = $mysqli->query($sql);
$qtd = $res->num_rows;
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
<section id="courses">
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
        <div class="courses-content">
            <div class="card-list-content">
                <ul class="card-list">
                    <?php
                        if ($qtd > 0) {
                            while ($row = $res->fetch_object()) {
                                $available = $row->max_tickets - $row->bought;
                                echo '
                                <li id="show_<?php echo $row->id_show; ?>" class="card">
                                <div class="overlay" onclick="addToCart(' . $row->id_show .')"></div>
                                        <div class="card-image">
                                            <img src="' . $row->image_show . '" alt="show cover">
                                        </div>
                                        <div class="card-title">
                                            <h4 class="title">' . $row->name_show . '</h4>
                                            <h4 class="artist">' . $row->name_artist . '</p>                                                                                           
                                        </div>
                                        <div class="card-description">
                                            <p>' . $row->description_show . '</p>                                                                                           
                                        </div>
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
        <div class="pagination">
            <?php
                $total_pages = ceil($qtdShows / $results_per_page);

                if ($page > 1) {
                    // echo '<a href="?page=1&order=' . $order . '&others=' . $filter . '"><<</a>';
                    echo '<a href="?page=' . ($page - 1) . '&order=' . $order . '&others=' . $filter . '"><</a>';
                }

                for ($i = max(1, $page - 5); $i <= min($page + 5, $total_pages); $i++) {
                    echo '<a href="?page=' . $i . '&order=' . $order . '&others=' . $filter . '&search=' . $search . '"';
                    
                    if ($i == $page) {
                        echo ' class="active"';
                    }
                    echo '>' . $i . '</a>';
                }

                if ($page < $total_pages) {
                    echo '<a href="?page=' . ($page + 1) . '&order=' . $order . '&others=' . $filter . '">></a>';
                    // echo '<a href="?page=' . $total_pages . '&order=' . $order . '&others=' . $filter . '">>></a>';
                }
            ?>
        </div>
    </div>
    </section>
</body>
</html>

<?php
require_once './components/footer.php';
?>