<?php
    include 'inc/functions.php';

    handleForm();

    $actions = [
        'refresh' => 'Reloads the page, however the link in the navbar can also refresh the page.',
        'download' => 'Downloads x number of unique images from <a href="http://unsplash.com">Unsplash</a>.',
        'erase' => 'Removes all the current images. No new images are added.',
    ]
?>
<!DOCTYPE html>
<html>
<head>
    <title>Homework 2 - Random Image Downloader</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        html {
            background: url('<?= getRandomImage() ?>') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <header>
        <h1>Random Image Downloader/Preview</h1>
    </header>
    <nav>
        <a href="">Reload</a>
    </nav>
    <main>
        <p>
            <strong>
                Use the form below, to select an operation. Download will download the specified number
                of unique images from Unsplash. The search term will be used to find images with that term on Unsplash.
            </strong>
        </p>
        <ul>
            <?php foreach ($actions as $key => $description) : ?>
                <li>
                    <strong><?= ucwords($key) ?></strong>- <?= $description ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <form method="post">
            <div class="form-field">
                <label for="type">Action Type</label>
                <select name="type">
                    <?php
                        foreach ($actions as $key => $description) {
                            echo '<option value="'. $key .'">'.ucwords($key).'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-field">
                <label for="search">Search</label>
                <input type="text" name="search" placeholder="Search...(ex. space)">
            </div>
            <div class="form-field">
                <label for="count">Number of Images</label>
                <input type="number" name="count" value="5">
            </div>
            <input type="submit" value="Go!">
        </form>
    </main>
    <footer>
        CST 336. 2018 &copy; Krause <br />
        <strong>Disclamer:</strong> The information in this webpage is fictitous. <br />
        It is used for academic purposes only.
        <br /><br />
        <img src="img/csumb.png" alt="CSUMB logo">
    </footer>
</body>
</html>
