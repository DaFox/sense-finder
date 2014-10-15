<?php
namespace sense\finder\matcher;

class LastAccessed extends Timestamp {

    /**
     * @param string $file
     * @return int
     */
    public function getTimestamp($file)
    {
        return @fileatime($file);
    }
}