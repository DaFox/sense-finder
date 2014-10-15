<?php
namespace sense\finder\matcher;

class Composite implements Matcher {
    /**
     * All matchers within this composite must match.
     */
    const ALL = 1;

    /**
     * Any matcher within this composite must match.
     */
    const ANY = 2;

    /**
     * The filters used by this composite filter.
     *
     * @var Matcher[]
     */
    private $matchers;

    /**
     * The operating mode of the composite filter.
     *
     * @var int
     */
    private $mode;

    /**
     * @param array $matchers
     * @param int $mode
     */
    public function __construct(array $matchers = array(), $mode = self::ALL) {
        $this->matchers = $matchers;
        $this->mode     = $mode;
    }

    /**
     * @return int
     */
    public function getCost() {
        $sum = 0;

        foreach($this->matchers as $filter) {
            $sum += $filter->getCost();
        }

        return (int) round($sum / count($this->matchers));
    }

    /**
     * @return int
     */
    public function getMode() {
        return $this->mode;
    }

    /**
     * @param int $mode
     */
    public function setMode($mode) {
        $this->mode = $mode;
    }

    /**
     * @return Matcher[]
     */
    public function getMatchersSorted() {
        uasort($this->matchers, function(Matcher $a, Matcher $b) {
            if($a->getCost() == $b->getCost()) {
                return 0;
            }

            return ($a->getCost() < $b->getCost()) ? -1 : 1;
        });

        return $this->matchers;
    }

    /**
     * @param Matcher $filter
     */
    public function addMatcher(Matcher $filter) {
        $this->matchers[] = $filter;
    }

    /**
     *
     */
    public function match($base, $file) {
        $any = ($this->mode == self::ANY);

        foreach($this->getMatchersSorted() as $filter) {
            if($filter->match($base, $file) == $any) {
                return $any;
            }
        }

        return !$any;
    }
}