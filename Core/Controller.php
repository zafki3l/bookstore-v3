<?php

namespace Core;

abstract class Controller
{	
    protected function renderView(string $view, array $data = []): void
    {
        require_once VIEW_PATH . $view . '.php';
    }
}
