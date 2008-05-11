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
class googleauth
{
	private $_source='InvisCMS';
	
    public function sendLoginRequest($type,$login,$passwd,$service)
	{
		$csc=&$GLOBALS['csc'];
		if($csc->openConnection("google.com","HTTP/1.0",80))
		{
			if($csc->sendQuery("POST","https://google.com/accounts/ClientLogin","accountType=".$type."&Email=".rawurlencode($login)."&Passwd=".$passwd."&service=".$service."&source=".$this->_source,"application/x-www-form-urlencoded"))
			{
				print $csc->readAnswer(false,true);	
			}
		}
	}
}
?>