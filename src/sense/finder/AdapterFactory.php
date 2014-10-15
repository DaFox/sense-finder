<?php
namespace sense\finder;

use sense\core\Shell;
use sense\finder\adapter\ComSpecAdapter;

class AdapterFactory {

    /**
     * @return Adapter
     */
    public static function getBestAvailableAdapter() {
        # Check for the ComSpec and use ComSpecAdapter
        if(($cmd = Shell::which('cmd.exe')) !== null) {
            return self::getComSpecAdapter();
        }

        if(($cmd = Shell::which('find')) !== null) {
            return self::getFindAdapter();
        }

        return self::getNativeAdapter();
    }

    /**
     * @return ComSpecAdapter
     */
    public static function getComSpecAdapter() {
        return new ComSpecAdapter();
    }

    /**
     * @return Adapter
     */
    private static function getFindAdapter()
    {
    }

    /**
     * @return Adapter
     */
    private static function getNativeAdapter()
    {
    }
}