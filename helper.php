<?php

function error($msg)
{
    return $_SESSION['errors'][$msg];
}

function message($message)
{
    return $_SESSION[$message];
}

function generateToken()
{
    if (empty($_SESSION['CSRF-token'])) {
        return bin2hex(random_bytes(32));
    }
}

function expireToken()
{
    return time() + 3600;
}