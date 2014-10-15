<?php
namespace sense\core;

class Shell {
    public static function which($cmd) {
        $path = getenv('PATH');

        if($path !== false) {
            foreach(explode(PATH_SEPARATOR, $path) as $path) {
                $fp = $path . '/' . $cmd;

                if(is_executable($fp)) {
                    return $fp;
                }
            }
        }

        return null;
    }
}