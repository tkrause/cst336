<?php
    include 'inc/functions.php';
?>
<!doctype html>
<html>
    <head>
        <title>Random Password Generator</title>

        <link rel="stylesheet" href="/hw3/css/style.css">
    </head>
    <body>
        <header>
            <h1>Random Password Generator</h1>
        </header>

        <div id="password"><?= password(); ?></div>

        <form action="" method="post">
            <div class="form-group input-length">
                <label for="length">Password Length</label>
                <input type="range" value="<?= request_get('length', 8) ?>" min="1" max="64" oninput="onSliderInput(this)">
                <input type="number" name="length" id="length" max="64" min="1" value="<?= request_get('length', 8) ?>">
            </div>
            <div class="form-group">
                <label for="symbols">Include Symbols</label>
                <input type="checkbox" name="symbols"<?= check('symbols') ?>>
            </div>
            <div class="form-group">
                <label for="numbers">Include Numbers</label>
                <input type="checkbox" name="numbers"<?= check('numbers') ?>>
            </div>
            <div class="form-group">
                <label for="lowercase">Include Lowercase Characters</label>
                <input type="checkbox" name="lowercase"<?= check('lowercase') ?>>
            </div>
            <div class="form-group">
                <label for="uppercase">Include Uppercase Characters</label>
                <input type="checkbox" name="uppercase"<?= check('uppercase') ?>>
            </div>
            
            <div class="form-group text-center d-block">
                <input type="submit">
                <input type="reset">
            </div>
        </form>

        <footer>
            CST 336. 2018 &copy; Krause <br />
            <strong>Disclamer:</strong> The information in this webpage is fictitous. <br />
            It is used for academic purposes only.
            <br /><br />
            <img src="/hw3/img/csumb.png" alt="CSUMB logo">
        </footer>

        <script type="text/javascript">
            var objLength = document.getElementById('length');
            function onSliderInput (i) {
                objLength.value = i.value;
            }
        </script>
    </body>
</html>