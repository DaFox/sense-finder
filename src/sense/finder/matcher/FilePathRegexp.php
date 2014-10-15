<?php
namespace sense\finder\matcher;

class FilePathRegexp implements Matcher {
    private $_pattern;

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

    public function getCost() {
        return self::COST_VERYLOW;
    }

    public function match($base, $file) {
        foreach($this->_pattern as $pattern) {
            if(preg_match($pattern, $file)) {
                return true;
            }
        }

        return false;
    }
}