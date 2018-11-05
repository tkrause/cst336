<?php

define('IMAGE_FOLDER', realpath(__DIR__ . '/../img/photos/') . '/');
define('WEB_PATH', '/hw2');

function getImageListing() {
    return glob(IMAGE_FOLDER . '*');
}

function downloadImages($search, $count = 1) {
    $i = 0;

    do {
        $img = file_get_contents('https://source.unsplash.com/1080x720/?' . $search);
        $hash = md5($img);
        $filename = IMAGE_FOLDER . $hash . '.jpg';

        // Ignore this image if it exists already
        // unsplash seems to cache the random image
        if (! file_exists($filename)) {
            file_put_contents($filename, $img);
            $i++;
        }
    } while($i < $count);
}

function getRandomImage() {
    $files = getImageListing();
    $random = rand(0, count($files) - 1);

    $path = basename($files[$random]);

    return WEB_PATH . '/img/photos/' . $path;
}

function emptyImagesFolder() {
    // Remove all images that we find
    // Filter out null folders
    array_map('unlink',
        array_filter(getImageListing())
    );
}

function handleForm() {
    // Ignore empty forms
    if (empty($_POST))
        return;

    // Ensure a type is selected
    if (! array_key_exists('type', $_POST))
        return;

    switch ($_POST['type']) {
        case 'refresh':
            return;
        case 'erase':
            emptyImagesFolder();
            break;
        case 'download':
            $search = request_get('search', 'space');
            $count = request_get('count', 5);
            downloadImages($search, $count);
            break;
    }

}

function request_get($key, $default = null) {
    return array_get($_POST, $key, $default);
}

function array_get(array $arr, $key, $default = null) {
    return isset($arr[$key]) ? $arr[$key] : $default;
}