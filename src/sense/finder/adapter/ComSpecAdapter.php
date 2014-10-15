<?php
namespace sense\finder\adapter;

class ComSpecAdapter extends CommandAdapter {

    public function __construct() {
        parent::__construct('cmd.exe /C dir /s /b');
    }

    /**
     * @param $directory
     * @param $type
     * @return \Generator
     */
    public function getFileList($directory, $type = self::FILES) {
        if(($type & self::FILES) === self::FILES) {
            $this->command .= ' /A:-D';
        }

        if(($type & self::DIRECTORIES) === self::DIRECTORIES) {
            $this->command .= ' /A:D';
        }

        return $this->createFileList($directory);
    }

    protected function filterFileName($fileName)
    {
        return str_replace('\\', '/', $fileName);
    }
}
