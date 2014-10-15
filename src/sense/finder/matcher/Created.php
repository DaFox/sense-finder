<?php
namespace sense\finder\matcher;

class Created extends Timestamp {

    /**
     * @param string $file
     * @return int
     */
    public function getTimestamp($file)
    {
        return @filectime($file);
    }
}