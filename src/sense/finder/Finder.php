<?php
namespace sense\finder;


use sense\finder\matcher\Matcher;


class Shell {
    public static function which($cmd) {
        $path = getenv('PATH');

        if($path !== false) {
            foreach(explode(PATH_SEPARATOR, $path) as $path) {
                $fp = $path . '/' . $cmd;

                if(is_executable($fp)) {
                    return $fp;
                }
            }
        }

        return null;
    }
}

interface FileListAdapter {
    const FILES = 1;
    const DIRECTORIES = 2;

    /**
     * @param $directory
     * @param $type
     * @return \Generator
     */
    public function getFileList($directory, $type = self::FILES);
}

abstract class CommandFileListAdapter implements FileListAdapter {

    protected $command;



    public function __construct($command) {
        $this->command = $command;
    }

    /**
     * @param $directory
     * @return \Generator
     * @throws FileSearchException
     */
    public function createFileList($directory) {
        $command = $this->command . ' ' . escapeshellarg($directory);
        $stream  = popen($command, 'r');

        if(!is_resource($stream)) {
            throw new FileSearchException(
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

class ComSpecFileListAdapter extends CommandFileListAdapter {

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

class FileListAdapterFactory {

    public static function getBestAvailableAdapter() {
        # Check for the ComSpec and use ComSpecAdapter
        if(($cmd = Shell::which('cmd.exe')) !== null) {
            return self::getComSpecAdapter($cmd);
        }
    }

    public static function getComSpecAdapter($cmd) {
        return new ComSpecFileListAdapter($cmd);
    }
}

class Finder {

    private $directory;

    private $offset;

    /**
     * @var FileListAdapter
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
        return $this->getFileListAdapter()->getFileList($this->directory, FileListAdapter::FILES);
    }

    /**
     * @return \Generator
     */
    public function getDirectories() {
        return $this->getFileListAdapter()->getFileList($this->directory, FileListAdapter::DIRECTORIES);
    }

    /**
     * @return FileListAdapter
     */
    public function getFileListAdapter() {
        if($this->fileListAdapter === null) {
            $this->fileListAdapter = FileListAdapterFactory::getBestAvailableAdapter();
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