<?php
    include 'inc/phpFuncs.php';
    include 'inc/header.php';
    
    $petList = getPetList();
?>

    <div class="container">
        <div id="carousel-pets" class="carousel slide m-auto" data-ride="carousel" style="width: 300px;">
            <ol class="carousel-indicators">
                <?php foreach ($petList as $i => $pet) : ?>
                    <li data-target="#carousel-pets" data-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></li>
                <?php endforeach; ?>
            </ol>

            <div class="carousel-inner">
                <?php foreach ($petList as $i => $pet) : ?>
                    <div class="carousel-item<?= $i == 0 ? ' active' : '' ?>">
                        <img src="img/<?= $pet['pictureURL'] ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#carousel-pets" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#carousel-pets" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>

        <div class="text-center">
            <a class="m-3 btn btn-outline-info" href="pets.php" role="button">Adopt Now!</a>
        </div>
    </div>
    <hr>
<?php
    include 'inc/footer.php';
?>