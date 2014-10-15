<?php
namespace sense\finder\matcher;

class Accept implements Matcher {

    /**
     * Returns the cost of this filter.
     *
     * The cost indicates how much resources are used by the filter. The filters
     * are sorted by the cost to execute the fastest filters first.
     *
     * @return int
     */
    public function getCost()
    {
        return 10;
    }

    /**
     * @param $base
     * @param $file
     * @return bool
     */
    public function match($base, $file)
    {
        return true;
    }
}