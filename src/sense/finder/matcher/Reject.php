<?php
namespace sense\finder\matcher;

class Reject extends Negate {

    public function __construct() {
        parent::__construct(new Accept());
    }
}