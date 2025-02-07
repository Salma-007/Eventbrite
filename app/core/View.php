<?php
namespace App\Core;
use eftec\bladeone\BladeOne;

class View {
    private static $blade = null;

    private static function init() {
        if (self::$blade === null) {
            $views = __DIR__ . '/../views/back';
            $cache = __DIR__ . '/../../storage/cache';

            self::$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }
    }

    public static function render($view, $data = []) {
        self::init();
        echo self::$blade->run($view, $data);
    }
}
