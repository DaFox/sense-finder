<?php
namespace sense\finder\adapter;

use sense\finder\Adapter;
use sense\finder\FinderException;

abstract class CommandAdapter implements Adapter {

    protected $command;



    public function __construct($command) {
        $this->command = $command;
    }

    /**
     * @param $directory
     * @return \Generator
     * @throws FinderException
     */
    public function createFileList($directory) {
        $command = $this->command . ' ' . escapeshellarg($directory);
        $stream  = popen($command, 'r');

        if(!is_resource($stream)) {
            throw new FinderException(
                "Unable to execute $command."
            );
        }

        while(($file = fgets($stream, 260)) !== false) {
            yield $this->filterFileName(rtrim($file, "\r\n"));
        }

        pclose($stream);
    }

    abstract protected function filterFileName($fileName);
}