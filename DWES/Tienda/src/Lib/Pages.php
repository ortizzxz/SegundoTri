<?php
namespace Lib;

class Pages {

    public function render(string $pageName, array $params = null): void {
        if ($params != null) {
            foreach ($params as $name => $value) {
                $$name = $value;
            }
        }

        $directorioSuperior = dirname(__DIR__, 1);

        require_once $directorioSuperior . '/views/Layout/header.php';
        require_once $directorioSuperior . '/views/' . $pageName . '.php';  
        require_once $directorioSuperior . '/views/Layout/footer.php';
    }
}
