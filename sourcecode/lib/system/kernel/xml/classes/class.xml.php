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
class xml{
	
	private $_inited=false;
	protected $_object=null;
	
	public function init($path,$file=true)
	{
		if($this->_object=@call_user_func(("simplexml_load_".(($file)?"file":"string")),$path))
		{
			$this->_inited=true;
			return true;
		}else
		{
			return false;
		}
	}
	
	public function getObject()
	{
		return $this->_object;
	}
	
	public function xpath_node($path)
	{
		$result=null;
		if($this->_inited)
		{
			$path=explode("/",$path);
			#die_r($path);
			$ob=$this->_object;
			for($i=0;$i<count($path);$i++)
			{
				#die_r($ob->{$path[$i]});
				if(isset($ob->{$path[$i]}))
				{
					$ob=$ob->$path[$i];
				}else{
					return null;
				}
			}
			$result=$ob;
		}
		return $result;
	}
	
	public function xpath_node_attr($path,$attr)
	{
		$node=$this->xpath_node($path);
		return (isset($node[$attr])?$node[$attr]:null);
	}
}
?>