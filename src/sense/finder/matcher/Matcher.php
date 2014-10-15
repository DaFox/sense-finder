<?php
namespace sense\finder\matcher;

interface Matcher {
    /**
     * Matchers that do string operations on the file name
     */
    const COST_VERYLOW  = 100;

    /**
     * Matchers that do string and memory operations
     */
    const COST_LOW      = 200;

    /**
     * Matchers that do inode lookups, like filectime, etc.
     */
    const COST_MIDDLE   = 300;

    /**
     * Matchers with I/O
     */
    const COST_HIGH     = 400;

    /**
     * Matchers with network I/O
     */
    const COST_VERYHIGH = 500;

    /**
     * Returns the cost of this filter.
     *
     * The cost indicates how much resources are used by the filter. The filters
     * are sorted by the cost to execute the fastest filters first.
     *
     * @return int
     */
    public function getCost();

    /**
     * @param string $base
     * @param string $file
     * @return bool
     */
    public function match($base, $file);
}