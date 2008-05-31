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
class clients implements iclients{
	
	/**
	 * Get client unque identifier
	 *
	 * @return Integer
	 */
	public function getUID()
	{
		$database=&$GLOBALS['database'];
		$id=$database->getSQLParameter("clients","id",array("ip"=>$_SERVER['REMOTE_ADDR']));
		return ($id==-1)?$_SERVER['REMOTE_ADDR']:$id;	
	}
	
	public function createProfile($data)
	{
		$database=&$GLOBALS['database'];
		$result=false;
		if(is_array($data))
		{
			$pid=$database->insertRow("accounts",array("",$data['phone'],$data['country'],$data['address'],$data['title'],$data['name'],$data['delivery'],$data['fromwhere'],$data['quality'],$data['paysys'],$data['payinfo'],'on'));
			if(!$database->isError())
			{
				$result=$pid;
			}
		}
		return $result;
	}
	
	public function createAccount($email,$passwd,$pid,$type)
	{
		$database=&$GLOBALS['database'];
		$result=false;
		if(!$database->checkRowExists("clients",array("email"=>$email)))
		{
			$q=$database->insertRow("clients",array("",$pid,$email,md5($passwd),"",$type,$_SERVER['REMOTE_ADDR'],time(),"on"));
			if(!$database->isError()) $result=true;
		}
		return $result;
	}
	
	/**
	 * Check is visitor registered client
	 *
	 * @return Boolean
	 */
	public function isClient()
	{
	}
	
	/**
	 * Create new client account
	 *
	 * @param Array $data
	 */
	public function addClient($data=array())
	{
	
	}
	
	/**
	 * Change client account status (enable or disable)
	 *
	 * @param Integer $id
	 * @param Boolean $status
	 */
	public function changeStatus($id,$status)
	{
		
	}
	
	/**
	 * Get last operation what making client under account
	 *
	 * @param Integer $uid
	 */
	public function getHistory($uid)
	{
		
	}
	
	public function sessionInit($uid)
	{
		$sessions=&$GLOBALS['sessions'];
		if(!$sessions->isDeath("userAuth_".md5($uid)))
		{
			if($sessions->registerData("userAuth_".md5($uid),'fa',array(time(),3600*60)))
			{
				return true;
			}
		
		}		
		return false;
	}
	
	public function info(){
		$result=array();
		return $sessions->getData("userAuth_".md5($uid));
	}
	
}
?>