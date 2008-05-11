<?php
class logs_event
{
	private $subject;
	private $body;
	private $time;
	private $place;
	private $environment;

	public function __construct($subject=null,$body=null,$time=null,$place=null,$environment=null)
	{
	}
	
	public function set($field,$value)
	{
		if(isset($this->$field)) $this->$field=$value;
	}
	
	public function get()
	{
		if(isset($this->$field)) return $this->$field;
	}
	
	public function map()
	{
		return serialize(get_class_vars(get_class($this)));
	}
}
?>