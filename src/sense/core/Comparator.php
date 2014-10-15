<?php
namespace sense\core;

class Comparator {

    public function __construct($threshold, $operator = 'eq') {
        $this->threshold = $threshold;
        $this->operation = $this->getOperation($operator);
    }

    /**
     * @param $current
     * @internal param $threshold
     * @internal param $operator
     * @return bool
     */
    public function compare($current) {
        return call_user_func($this->operation, $current);
    }

    /**
     * @param $operator
     * @return \Closure
     * @throws \Exception
     */
    private function getOperation($operator) {
		switch($operator) {
			case 'lte':
			case '<=':
				return function($current) {
                    return $current <= $this->threshold;
                };

			case 'lt':
			case '<':
				return function($current) {
                    return $current < $this->threshold;
                };

			case 'eq':
			case '==':
				return function($current) {
                    return $current == $this->threshold;
                };

			case 'neq':
			case '!=':
				return function($current) {
                    return $current != $this->threshold;
                };

			case 'gt':
			case '>':
				return function($current) {
                    return $current > $this->threshold;
                };

			case 'gte':
			case '>=':
				return function($current) {
                    return $current >= $this->threshold;
                };
		}

        throw new \Exception("No such operator: $operator");
    }
}