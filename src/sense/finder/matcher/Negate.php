<?php
namespace sense\finder\matcher;

class Negate implements Matcher {

    /**
     * @var Matcher
     */
    private $matcher;

    /**
     * @param Matcher $matcher
     */
    public function __construct(Matcher $matcher) {
        $this->matcher = $matcher;
    }

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
        return $this->matcher->getCost() + 10;
    }

    /**
     * @param string $base
     * @param string $file
     * @return bool
     */
    public function match($base, $file)
    {
        return !$this->matcher->match($base, $file);
    }
}