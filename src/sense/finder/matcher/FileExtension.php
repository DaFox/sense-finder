<?php
namespace sense\finder\matcher;

class FileExtension implements Matcher {
    /**
     * @var array
     */
    private $ext;

    /**
     * @param array|string $ext
     */
    public function __construct($ext) {
        if(!is_array($ext)) {
            $ext = array($ext);
        }

        $this->ext = $ext;
    }

    /**
     * @return int
     */
    public function getCost() {
        return self::COST_VERYLOW;
    }

    /**
     * @param string $base
     * @param string $file
     * @return bool
     */
    public function match($base, $file) {
        return in_array(pathinfo($base . DIRECTORY_SEPARATOR . $file, PATHINFO_EXTENSION), $this->ext);
    }
}