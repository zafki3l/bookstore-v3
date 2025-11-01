<?php

namespace Core;

/**
 * Class Controller
 * 
 * BaseController provides helper methods for All Controller classes
 */
abstract class Controller
{	
    /**
     * Render a specified view 
     * @param string $view
     * @param array $data
     * @return mixed
     */
    private function render(string $view, array $data = []) : mixed
    {
        extract($data);
        return require_once VIEW_PATH . $view . '.php';
    }

    /**
     * Render a view with a layout
     * 
     * @param string $view
     * @param string $layout_view
     * @param string $title
     * @param array $data
     * @return mixed
     */
    protected function view(string $view, string $layout, array $data = []) : mixed
    {
        ob_start();
        $view = $this->render($view, $data);

        $title = $data['title'] ?? 'Document';

        $view_data = [
            'title' => $title,
            'content' => ob_get_clean(),
        ];

        return $this->render($layout, $view_data);
    }
}