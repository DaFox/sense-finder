<?php
namespace sense\finder\matcher;

use sense\core\Comparator;

class FileSize implements Matcher {

    /**
     * @param int $threshold
     * @param string $operator
     */
    public function __construct($threshold, $operator = 'lte') {
        $this->comparator = new Comparator($threshold, $operator);
    }

    /**
     * @return int
     */
    public function getCost() {
        return self::COST_LOW;
    }

    /**
     * @param string $base
     * @param string $file
     * @return bool
     */
    public function match($base, $file)
    {
        if(($fs = @filesize($file)) === false) {
            return false;
        }

        return $this->comparator->compare($fs);
    }
}