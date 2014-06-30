<?php

/**
 * Description of Timer
 *
 * @author jacoe
 */
namespace Debug\Service;

class Timer {
    /**
     * Start times 
     * @var array
     */
    protected $start;
    
    /**
     * Defines if times have to be presented as float
     * @var boolean
     */
    protected $timeAsFloat;
    
    public function __construct($timeAsFloat = false) {
        $this->timeAsFloat = $timeAsFloat;
    }
    
    /**
     * Start measuring time
     * @param string $key
     */
    public function start($key) {
        $this->start[$key] = microtime($this->timeAsFloat);
    }
    
    /**
     * Stop measuring and return result
     * @param string $key
     * @return float|null the duration of the event
     */
    public function stop($key) {
        if (!isset($this->start[$key])) {
            return null;
        }
        return microtime($this->timeAsFloat) - ($this->start[$key]);
    }
}

?>
