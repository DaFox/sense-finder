<?php
namespace sense\finder\matcher;

abstract class Timestamp implements Matcher {
    private $from;
    private $till;

    /**
     * @param int $from
     * @param int $till
     */
    public function __construct($from, $till = PHP_INT_MAX) {
        $this->from = !is_int($from) ? strtotime($from) : $from;
        $this->till = !is_int($till) ? strtotime($till) : $till;
    }

    /**
     * @param string $base
     * @param string $file
     * @return bool
     */
    public function match($base, $file) {
        if(($time = $this->getTimestamp($base . DIRECTORY_SEPARATOR . $file)) === false) {
            return false;
        }

        return $time >= $this->from && $time <= $this->till;
    }

    /**
     * @return int
     */
    public function getCost() {
        return self::COST_MIDDLE;
    }

    /**
     * @param string $file
     * @return int
     */
    public abstract function getTimestamp($file);
}