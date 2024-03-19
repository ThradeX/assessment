<?php
require_once './components/header.php';

$genres = array( // Initializing an array of music genres with their respective images.
    array("name" => "Rock", "image" => "./images/rock.jpg"),
    array("name" => "Rap", "image" => "./images/rap.jpg"),
    array("name" => "Pop", "image" => "./images/pop.jpg"),
    array("name" => "Eletronic", "image" => "./images/eletronic.jpg")
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/home.css">
</head>
<body>
    <section class="home-body">
        <div class="home-content">
            <div class="cards">
                <?php
                    foreach ($genres as $genre) { // Iterating through each genre in the array.
                        $genreName = $genre["name"]; // Storing the genre name.
                        $backgroundImage = $genre['image']; // Storing the path to the genre's image.
                        include './components/card-home.php'; // Including the card component for each genre.
                    }
                ?>
            </div>
            <div class="text-box">
                <p>We have it all here because</p>
                <p>WE LOVE LIVE MUSIC!</p>
            </div>
        </div>
    </section>
</body>
</html>

<?php
require_once './components/footer.php';
?>