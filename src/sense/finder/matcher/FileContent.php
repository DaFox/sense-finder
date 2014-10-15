<?php
namespace sense\finder\matcher;

class FileContent implements Matcher {
	protected $search;
	protected $ignoreCase;
	
	public function __construct($search, $ignoreCase = false) {
		$this->search     = $search;
		$this->ignoreCase = $ignoreCase;
	}
	
	/**
	* Returns the cost of this filter (high).
	*
	* @return int
	*/	
	public function getCost() {
		return self::COST_HIGH;
	}

    /**
     * @param string $base
     * @param string $file
     * @return bool
     */
    public function match($base, $file) {
		$buffer = '';
		$offset = strlen($this->search);
		
		if(($stream = @fopen($base . DIRECTORY_SEPARATOR . $file, 'r')) !== false) {
			while(!feof($stream)) {
				$delta  = strlen($buffer) > 0 ? substr($buffer, -$offset) : '';
				$buffer = fread($stream, 1024);
				
				if($this->matchChunk($delta . $buffer)) {
					return true;
				}
			}
		}

		return false;
	}

    /**
     * @param string $content
     * @return mixed
     */
    public function matchChunk($content) {
        return $this->ignoreCase
            ? stripos($content, $this->search)
            : strpos($content, $this->search);
    }
}