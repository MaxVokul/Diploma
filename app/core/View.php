<?php

class View {
    public function render($view, $data = []) {
        extract($data);

        // Подключаем layout
        include '../header.php';
        include "../app/views/{$view}.php";
        include '../footer.php';
    }

    public function renderPartial($view, $data = []) {
        extract($data);
        include "../app/views/{$view}.php";
    }
}