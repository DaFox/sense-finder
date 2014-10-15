<?php
namespace sense\finder\matcher;

class LastModified extends Timestamp {

    /**
     * @param string $file
     * @return int
     */
    public function getTimestamp($file)
    {
        return @filemtime($file);
    }
}