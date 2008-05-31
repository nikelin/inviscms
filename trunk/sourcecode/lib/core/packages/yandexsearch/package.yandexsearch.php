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
?><?php
class yandexsearch
{
	private $_query=null;
	private $_max_passages=2;
	private $_encoding='windows-1251';
	private $_text=null;
	private $_head='';
	private $_page=0;
	private $_maxpassages=6;
	private $_host="xmlsearch.yandex.ru";
	
	public function __construct()
	{
		$this->_head='<?xml version="1.0" encoding="windows-1251"?>';
	}
	
	public function setHost($host){$this->_host=$host;}
	public function setEncoding($value="utf-8"){$this->_encoding=$value;}
	public function setQueryCat($cat){}
	public function setMaxPassages($value=2){$this->_max_passages=$value;}
	public function setSorting($attr,$mode,$groups_per_page,$docs,$curcat=-1){}
	public function setText($query)
	{
		$this->_text=$query;
	}
	
	public function setCurrPage($page){$this->_page=$page;}
	
	public function sendQuery()
	{
		$csc=&$GLOBALS['csc'];
		$this->_query='
		<request>
		<query>'.htmlspecialchars($this->_text).' &lt;&lt; host=\'tnt43.com\'</query>
		<maxpassages>'.$this->_maxpassages.'</maxpassages>
		<groupings>
		<groupby attr="d" mode="deep" groups-on-page="10"  docs-in-group="1" />
		</groupings>
		</request>';
		$this->_data=$this->_head.$this->_query;
		#die_r($this->_data);
		$csc->openConnection($this->_host,"http",80);
		$csc->sendQuery("POST","/xmlsearch",$this->_data);
		return $csc->readAnswer();
	}
	
	public function renderResults()
	{
		
	}
}
?>