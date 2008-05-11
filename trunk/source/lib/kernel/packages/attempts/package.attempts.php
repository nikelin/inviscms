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
class attempts
{
	private $_collection_mode=false;
	private $_realtime_mode=true;
	
	public function __construct()
	{
	}
	
	public function send($subject,$text)
	{
		$mail=&$GLOBALS['mail'];
		$cronjobs=&$GLOBALS['cronjobs'];
		if($this->_realtime_mode)
		{
			$mail->setFrom("robot@futbolkaprint.com.ua","Attempts Server");
			$mail->setSubject($subject);
			$mail->addTo("kulinichsergey@gmail.com","Someman");
			$mail->setBodyHTML($text,"utf-8");
			$mail->send();
		}
	}
	
	public function setCollectionMode($status=true){}
	public function setRealtimeMode($status=true){}
	public function sendLinksMode($status=false){}
	public function setSendTime($date){}
	public function setMasterAddress($value){}
	public function setAliaseAddress($value){}
	public function deleteRecipient($value){}
}
?>