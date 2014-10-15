<?php
namespace sense\finder\matcher;

/**
 * Class FileNameRegexp
 *
 * @package sense\finder\matcher
 */
class FileNameRegexp implements Matcher {
    /**
     * @var array
     */
    private $_pattern;

    /**
     * @param $pattern
     */
    public function __construct($pattern) {
        if(!is_array($pattern)) {
            $pattern = array($pattern);
        }

        $this->_pattern = array_map(array($this, 'compilePattern'), $pattern);
    }

    /**
     * Enter the documentation here.
     *
     * @param string $pattern
     * @return string
     */
    private function compilePattern($pattern) {
        return '/^' . $pattern . '$/';
    }

    /**
     * @return int
     */
    public function getCost() {
        return self::COST_VERYLOW;
    }

    /**
     * @param string $base
     * @param string $file
     * @return bool
     */
    public function match($base, $file) {
        foreach($this->_pattern as $pattern) {
            if(preg_match($pattern, basename($file))) {
                return true;
            }
        }

        return false;
    }
}