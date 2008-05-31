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
class patchcontroll
{
	public $_ask_agree=true;
	public $_validate_on_server=true;
	public $_make_backup=true;
	public $_install_untrusted=false;
	
	public function __construct()
	{
		if(!isset($GLOBALS['system']) || !isset($GLOBALS['pclzip']))
		{
			return 0;
		}
	}
	
	private function parse_patch()
	{
		$data=$this->_zipdata->extractByIndex("patch.tar");
		
	}
	
	public function init($path)
	{
		$result=0;
		if(!class_exists("pclzip"))
		{
			$this->_zipdata=new pclzip();
			$this->_zipdata->init($path);
			$this->_contents=$this->_zipdata->listContents();
			$result=1;
		}
		return $result;	
	}
	
	public function validate_package()
	{
		$d=@simplexml_load_file($system->getPath("system").'/others/xml/patch_specification.xml');
		if($d && $d->item){
			for($i=0;$i<count($d->item);$i++)
			{
				if($d->item['important'] && !$this->_zipdata->in_package($d->item[$i]['name'])) return false;
			}
		}else{
			return false;
		}
	}
	public function make_backup()
	{
		
	}
	
	public function install_patch(){}
	public function ask_agree(){}
	
}
?>