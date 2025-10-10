<?php

foreach (glob('../configs/*.php') as $filename) {
    require_once $filename;
}

foreach (glob(BASE_PATH . '/Core/*.php') as $filename) {
    require_once $filename;
}

foreach (glob(BASE_PATH . '/app/Models/*.php') as $filename) {
    require_once $filename;
}

foreach (glob(BASE_PATH . '/app/Controllers/*.php') as $filename) {
    require_once $filename;
}