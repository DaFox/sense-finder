<?php
namespace sense\finder\matcher;


class FileName implements Matcher {
    /**
     * The shell wildcard pattern to match against.
     *
     * @var string|array
     */
    private $pattern;

    /**
     * The flags to modify the behaviour of the filter.
     *
     * @var int
     */
    private $flags = 0;

    /**
     * Creates a new file path filter.
     *
     * The value of flags can be any combination of the following flags,
     * joined with the binary OR operator.
     *
     * - FNM_NOESCAPE
     * - FNM_PATHNAME
     * - FNM_PERIOD
     * - FNM_CASEFOLD
     *
     * @param string|array $pattern Shell wildcard pattern to match against
     * @param int $flags Flags to modify the filter
     * @link http://www.php.net/fnmatch Read the manual page of the fnmatch()
     *   function to learn more about the possible flags.
     */
    public function __construct($pattern, $flags = 0) {
        if(!is_array($pattern)) {
            $pattern = array($pattern);
        }

        $this->pattern = $pattern;
        $this->flags   = $flags;
    }

    /**
     * Returns the cost of the filter implementation.
     *
     * @return int {@link FileSearchFilter::COST_VERYLOW}
     */
    public function getCost() {
        return self::COST_VERYLOW;
    }

    /**
     * The file is accepted by this filter, if the file path matches
     * against the specified pattern.
     *
     * @param $base
     * @param string $file The absolute path of the file to check
     * @return boolean TRUE if the file was accepted, FALSE otherwise
     */
    public function match($base, $file) {
        foreach($this->pattern as $pattern) {
            if(fnmatch($pattern, basename($file), $this->flags)) {
                return true;
            }
        }

        return false;
    }
}