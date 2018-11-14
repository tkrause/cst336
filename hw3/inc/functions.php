<?php

function request_get($key, $default = null)
{
    return isset($_REQUEST[$key]) && ! empty($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
}

function request_is($key)
{
    return isset($_REQUEST[$key]);
}

function buildCharlist()
{
    $lists = [
        'symbols' => '" !"#$%&\\\'()*+,-./:;<=>?@[\]^_`{|}~"',
        'numbers' => '0123456789',
        'lowercase' => 'abcdefghijklmnopqrstuvwxyz',
        'uppercase' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    ];

    $charlist = '';
    foreach ($lists as $key => $chars) {
        $charlist .= request_is($key) ? $chars : '';
    }

    return $charlist;
}

function password()
{
    $charlist = buildCharlist();
    if (empty($charlist)) {
        return 'Select some characters to include';
    }

    return generatePassword($charlist, request_get('length', 8));
}

function generatePassword($charlist, $length = 8)
{
    $pass = '';
    $size = strlen($charlist) - 1;
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $size);
        $pass .= $charlist[$n];
    }

    return $pass;
}

function check($key, $default = false)
{
    return request_is($key) ? ' checked' : '';
}