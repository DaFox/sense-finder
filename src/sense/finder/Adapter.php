<?php
namespace sense\finder;

interface Adapter {
    const FILES = 1;
    const DIRECTORIES = 2;

    /**
     * @param $directory
     * @param $type
     * @return \Generator
     */
    public function getFileList($directory, $type = self::FILES);
}