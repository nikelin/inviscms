<?php
class  xmldoc
{
	
	private $_tags=array();
	
	public function __construct(){}
	
	public function addTag($parent,$name,$type){}
	
	public function addParam($tag,$name,$value,$namespace){}
	
	public function addNameSpace($id,$href){}
	
	public function setNodeData($tag,$data){}
	
	public function removeTag($path){}
	
	public function removeAttribute($path,$name){}
	
	public function applyXSL($href){}
	
	public function startDoc($version='1.0',$encoding='utf-8',$standalone='yes'){} 
	
	public function addDTDSpec($name,$href){}
	
	public function renderXML(&$link){}
	
	public function renderTree(&$link){}
	
	/**
	 * Parser implementing
	 * @return Array
	 */
	public function loadXML(){}

}
 ?>