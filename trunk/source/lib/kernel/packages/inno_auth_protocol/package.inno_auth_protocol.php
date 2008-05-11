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
class inno_auth_protocol{
	
	private $_server='';
	private $_inited='';
	private $_asid=null;
	private $_sid=null;
	
	public function hello_send($host,$server)
	{
		$csc=new csc();
		$this->_host=$host;
		$this->_server=$server;
		if($csc->openConnection($host))
		{
			if($csc->sendQuery("POST",$server,"req=hello"))
			{
				if($csc->readAnswer()=="hello")
				{
					$this->_inited=true;
					return true;
				}
			}
		}
		return false;
	}
	
	public function proceed_authorize()
	{
		$result=null;
		if($this->_inited)
		{
			if($csc->openConnection($host))
			{
				if($csc->sendQuery("POST",$server,"req=authorize"))
				{
					$this->_asid=$csc->readAnswer();
				}
			}	
		}
		return $result;
	}
	
	public function getSID()
	{
		return $this->_sid;
	}
	
	public function authentificate($message)
	{
		$result=false;
		if($this->_inited)
		{
			if($csc->openConnection($host))
			{
				if($csc->sendQuery("POST",$server,"req=authentificate&asid=".$this->_asid."&key=".$this->encr($message,$this->_asid)))
				{
					if($this->_sid=$csc->readAnswer())
					{
						if(strlen($this->_sid)==32)
						{
							$result=$this->_sid;
						}
					}
				}
			}
		}
		return $result;
	}
}
?>