<?php
namespace sense\finder;


use sense\finder\matcher\Matcher;

class Finder {

    private $directory;

    private $offset;

    /**
     * @var Adapter
     */
    private $fileListAdapter;

    public function __construct($directory) {
        $this->directory = realpath($directory);
        $this->offset    = strlen($this->directory) + 1;
    }

    /**
     * @return \Generator
     */
    public function getFiles() {
        return $this->getFileListAdapter()->getFileList($this->directory, Adapter::FILES);
    }

    /**
     * @return \Generator
     */
    public function getDirectories() {
        return $this->getFileListAdapter()->getFileList($this->directory, Adapter::DIRECTORIES);
    }

    /**
     * @return Adapter
     */
    public function getFileListAdapter() {
        if($this->fileListAdapter === null) {
            $this->fileListAdapter = AdapterFactory::getBestAvailableAdapter();
        }

        return $this->fileListAdapter;
    }

    /**
     * @param Matcher $matcher
     * @return \Generator
     */
    public function search(Matcher $matcher) {
        foreach($this->getFiles() as $file) {
            if($matcher->match($this->directory, substr($file, $this->offset))) {
                yield $file;
            }
        }
    }
}