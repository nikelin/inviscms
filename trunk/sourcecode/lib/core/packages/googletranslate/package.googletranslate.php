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
	class googletranslate extends csc
	{
		private $_ghost='ajax.googleapis.com';
		private $_translate_server='/ajax/services/language/translate';
		private $_detect_server='/ajax/services/language/detect';
		private $_pv='1.0';
		private $_response=array();
		
		
		public function getResponseObject()
		{
			return $this->_response;
		}
			
		public function getResponseNode($path)
		{
			$path=explode("/",$path);
			$result=$this->_response;
			for($i=0;$i<count($path);$i++)
			{
				$result=$result[$path[$i]];
			}
			return $result;
		}
		
		public function translate($text,$dest,$source='en',$callback=array(),$decode=true)
		{
			$result=null;
			$jsondecoder=&$GLOBALS['jsondecoder'];
			if($this->openConnection($this->_ghost))
			{
				if($this->sendQuery("GET",$this->_translate_server."?v=".$this->_pv."&q=".rawurlencode($text)."&langpair=".$source."%7C".$dest."&callback=".$callback[0]."&context=".$callback[1]))
				{
					
					if($result=$this->readAnswer(false,true))
					{
						if($decode)
						{
							$this->_response=$jsondecoder->decode($result);
							$result=$this->_response['responseData']['translatedText'];
						}
					}else
					{
						$result=null;
					}
				}
			}
			return $result;
		}
		
		public function detect($text,$decode=true)
		{
			$result=null;
			$jsondecoder=&$GLOBALS['jsondecoder'];
			if($this->openConnection($this->_ghost))
			{
				if($this->sendQuery("GET",$this->_detect_server."?v=".$this->_pv."&q=".rawurlencode($text)))
				{
					
					if($result=$this->readAnswer(false,true))
					{
						if($decode)
						{
							$this->_response=$jsondecoder->decode($result);
							$result=$this->_response['responseData']['language'];
						}
					}else
					{
						$result=null;
					}
				}
			}
			return $result;
		}
	}
?>