<?php
namespace sense\finder\matcher;

class FileContentRegExp extends FileContent {

    /**
     * @param string $content
     * @return bool
     */
    public function matchChunk($content) {
        $pattern = '/' . $this->search . '/';

		if($this->ignoreCase) {
			$pattern .= 'i';
		}
		
		return (bool) preg_match($pattern, $content);
	}
}