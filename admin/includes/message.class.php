<?php
/**
 * The Message class.
 * 
 * This object is handled as a priority queue of messages, and will print out
 * the highest priority messages first.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 1.0 2014-07-13
 * 
 * @package AffinityFramework
 * @subpackage Admin
 */
class Message{
	
	const SUCCESS = 0;
	const NOTICE  = 1;
	const INFO    = 2;
	const NAG     = 3;
	const WARNING = 4;
	const ERROR   = 5;
	const SEVERE  = 6;
	
	private static $total_constants;
	private $messages = array();
	private $size = 0;
	
	public function __construct(){
		$this->_init_messages();
	}
	
	private function _init_messages(){
		$reflect = new ReflectionClass(__CLASS__);
		$constants = $reflect->getConstants();
		self::$total_constants = count($constants);
		foreach($constants as &$constant){
			$this->messages[$constant] = array();
		}
	}
	
	/**
	 * Inserts a Message into the message queue
	 * 
	 * @param int $level Message level
	 * @param string $message message string to display
	 * @throws Exception
	 */
	public function insert($level, $message){
		if($level >= self::$total_constants || $level < 0)
			throw new Exception("Level value out of bounds");
		
		$this->messages[$level][] = $message;
		$this->size++;
	}
	
	/**
	 * Determines if the Message queue is empty
	 * 
	 * @return boolean True if the queue is empty, false otherwise
	 */
	public function is_empty(){
		return $this->size==0;
	}
	
	/**
	 * Clears all internal messages
	 */
	public function clear(){
		$this->_init_messages();
	}
	
	public function print_level($level,$n=0, $class='callout'){
		if($level >= self::$total_constants || $level < 0)
			throw new Exception("Level value out of bounds");
		
		$count = 0;
		$lvlstr = self::level_to_string($level);
		if(!empty($this->messages[$level])){
			foreach((array) $this->messages[$level] as &$message){
				if($n!=0) $count++;
				
				echo("<div class='{$class} {$lvlstr}'>");
				echo("<strong>" . ucfirst($lvlstr) . "</strong>: {$message}");
				echo("</div>");
				
				if($n!=0 && $count==$n) 
					break;
			}
		}
		return $count;
	}
	
	public function print_out($n=1, $class='callout'){
		$i = count($this->messages);
		$count = 0;
		while($i){
			$count += self::print_level(--$i,$n - $count, $class);
			if($n!=0 && $count==$n) 
				break;
		}
	}
	
	/**
	 * Converts the integer level to a string
	 * 
	 * @param int $level Integer level
	 * @return string the string name of the level
	 */
	static function level_to_string($level){
		switch($level){
			case Message::SUCCESS:
				$result = "success";
				break;
			case Message::NOTICE:
				$result = "notice";
				break;
			case Message::INFO:
				$result = "info";
				break;
			case Message::NAG;
				$result = "nag";
				break;
			case Message::WARNING:
				$result = "warning";
				break;
			case Message::ERROR;
				$result = "error";
				break;
			case Message::SEVERE;
				// No break
			default:
				$result = "severe";
		}
		return $result;
	}
	
}
