<?php
    function array_get($key, $default = null) {
        return isset($_GET[$key]) && !empty($_GET[$key]) ? $_GET[$key] : $default;
    }

    $backgroundImage = "img/sea.jpg";
    $layout = array_get('layout');
    $keyword = array_get('keyword', array_get('category'));

    // API call goes here
    if (! empty($keyword)) {
        include 'api/pixabayAPI.php';

        $imageURLs = getImageURLs($keyword, $layout);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Image Carousel</title>
    <meta charset="utf-8">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url("css/styles.css");
        body {
            background-image: url('<?= $backgroundImage ?>');
            background-size: 100% 100%;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <br /><br />
    <! -- HTML form goes here! -->
    <div class="card bg-secondary w-50 m-auto">
        <div class="card-body">
            <form>
                <input class="form-control" type="text" name="keyword" placeholder="Keyword" value="<?= $keyword ?>"/>
                <div class="form-group text-white">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout" id="lhorizontal" value="horizontal"<?= $layout == 'horizontal' ? ' checked' : '' ?>>
                        <label class="form-check-label" for="lhorizontal">Horizontal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout" id="lvertical" value="vertical"<?= $layout == 'vertical' ? ' checked' : '' ?>>
                        <label class="form-check-label" for="lvertical">Vertical</label>
                    </div>
                </div>
                <div class="form-group">
                    <select id="list" name="category">
                        <option value="">Select One</option>
                        <option value="ocean">Sea</option>
                        <option value="forest">Forest</option>
                        <option value="mountain">Mountain</option>
                        <option value="snow">Snow</option>
                    </select>
                </div>
                <input class="btn btn-light" type="submit" value="Submit" />
            </form>
        </div>
    </div>

    <br />

    <?php
        if(! isset($imageURLs)){
            echo "<h2>Type a keyword or select a category to display a slideshow <br /> with random images from Pixabay.com </h2>";
        }
        else {
            // Display Carousel Here
            ?>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"<?= $layout == 'vertical' ? 'style="width: 300px;"' : '' ?>>
                <!-- Indicators Here -->
                <ol class="carousel-indicators">
                    <?php
                        for ($i = 0; $i < 7; $i++) {
                            echo "<li data-target='#carousel-example-generic' data-slide-to='$i'";
                            echo ($i == 0)?" class='active'": "";
                            echo "></li>";
                        }
                    ?>
                </ol>

                <!-- Wrapper for Images -->
                <div class="carousel-inner" role="listbox">
                    <?php
                        for ($i = 0; $i < 7; $i++) {
                            do {
                                $randomIndex = rand(0, count($imageURLs));
                            } while(! isset($imageURLs[$randomIndex]));

                            echo '<div class="carousel-item';
                            echo ($i == 0)?" active": "";
                            echo '">';
                            echo '<img src="' . $imageURLs[$randomIndex] . '">';
                            echo '</div>';
                            unset($imageURLs[$randomIndex]);
                        }
                    ?>
                </div>

                <!--Controls here-->
                <a class="left carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

    <?php } ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>