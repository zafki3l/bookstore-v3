<?php

namespace Core;

abstract class Controller
{	
    protected function renderView(string $view, array $data = []): void
    {
        require_once VIEW_PATH . $view . '.php';
    }

    protected function view(string $view, string $layout_view, string $title)
    {
        ob_start();
        $this->renderView($view);

        $data = [
            'title' => $title,
            'content' => ob_get_clean()
        ];

        $this->renderView($layout_view, $data);
    }
}
