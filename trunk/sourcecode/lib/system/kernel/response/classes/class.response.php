<?php
# This file is part of InvisCMS .
#
#    InvisCMS is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    Foobar is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with InvisCMS.  If not, see <http://www.gnu.org/licenses/>.
?><?
class response implements responseI{
	private $instances=array();
	private $_body='';
	private $_head='';
	private $response='';
	private $_setted=false;
	private $_root='';
	private $_errors='';
	public $indf='Cross-Server Communicator';
	
	function __construct(){
	         $this->_body='';
	         $this->_head='';
	}
	
	private function makeHeader(){
		$this->_head='<?xml version="1.0"?>';
		$this->_head.='<response>';
		$this->_root.='<genTime>'.time().'</genTime>';
		$this->_root.='<errors>'.$this->_errors.'</errors>';
	}
	
	public function errorSet($text){
			$this->_errors.='<error value="'.$text.'"/>';
			$this->setStatus(1021);
	}
	
	public function setStatus($status=200){
		if(!$this->_setted){
			$this->_root.='<status value="'.$status.'"/>';
			$this->_setted=true;
		}
	}
		
	
	public function appendMessage($text,$type){
			$this->_body.='<msg type="'.$type.'" value="'.$text.'"/>';
	}
	
	public function appendTag($name,$value){
			$this->_body.='<'.$name.'>'.$value.'</'.$name.'>';
	}
	
	
	private function _end(){
		$database=$GLOBALS['database'];
		 if(!$this->_setted)$this->setStatus();
		$this->response.=$this->_head;
		$this->response.=$this->_body;
		$rn=mt_rand(100000,999999);
		$this->_root.='<responseNumber>'.$rn.'</responseNumber>';/**$this->instances['system']->getLastResponse()**/
		$q=$database->insertRow("clx_responses",array("",$rn,time(),$_SERVER['REMOTE_ADDR']));
		if(!$q)
		{
			die("Impossible to save the current session identifier !".$database->sqlErrorString());
		}
		$this->response.=$this->_root;
		$this->response.='</response>';
	}
	
	public function makeResponse(){
		$this->makeHeader();
		$this->_end();
		return $this->response;
	}
	
}
?>
