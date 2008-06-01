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
class security{
	
	public function isAuthorized()
	{
		
	}
	
	public function userEmail($extr)
	{
		return $GLOBALS['database']->getSQLParameter("users","email",array("extr"=>$extr));
	}
	
	public function renewEXTR($old)
	{
		$system=&$GLOBALS['system'];
		$database=&$GLOBALS['database'];
		if($database->checkRowExists("users",array("extr"=>$old)))
		{
			$extr=$this->generateEXTR();
			if($database->updateRow("users",array("extr"=>$extr,"laccess"=>time()),array("extr"=>$old)))
			{
				#die($this->userEmail($extr));
				$GLOBALS['attempts']->send("Обновление ключа доступа EXTR","Ваш ключ быстрого доступа был обновлён: <a href='http://futbolkaprint.com.ua/admin/home/extr/".$extr."'>".$extr."</a>",$this->userEmail($extr));				
				return true;
			}
		}
		return false;
	}
	
	function generateEXTR()
	{
		return $GLOBALS['system']->makeRandString(16);;
	}	

	public function authorized($part)
	{
		$database=&$GLOBALS['database'];
		$sessions=&$GLOBALS['sessions'];
		$result=false;
		
		if(is_string($part))
		{
			switch($part)
			{
				case 'admin':
				#die($sessions->getData("admin_auth_".substr(md5($_SERVER['REMOTE_ADDR']),0,6)));
					$result=!($sessions->isDeath("admin_auth"));
					break;
				case 'client':
					$result=!($sessions->isDeath("user_auth"));
					break;
			}
		}
		return $result;
	}
	
	public function timeElapsed($part)
	{
		$when=$GLOBALS['sessions']->whenDie("admin_auth");
		return $when/60;
	}
	
	public function dropSession($part)
	{
		$sessions=&$GLOBALS['sessions'];
		$result=false;
		$part=($part=="client")?"user":"admin";
		$session=$part."_auth";
		if($sessions->terminate($session)){
			$result=true;
		}
		return $result;
	}
	
	public function proceedClientAuthorize($email,$password)
	{
		$database=&$GLOBALS['database'];
		$history=&$GLOBALS['history'];
		$sessions=&$GLOBALS['sessions'];
		$tools=&$GLOBALS['tools'];
		
		if(trim($email)!='' || trim($password)!='')
		{
			#die_r(func_get_args());
			$check=$database->checkRowExists("clients",array("email"=>$email,"passwd"=>md5($password)));
			if($check['status']=="ok")
			{
				if($database->updateRow("clients",array("laccess"=>time(),"ip"=>$_SERVER['REMOTE_ADDR']),array("id",$check['id'])))
				{
					if($sessions->registerData("user_auth",true,array(time(),3600*2)))
					{
						$history->newEvent("clientauthorize",time(),array("ip"=>$_SERVER['REMOTE_ADDR'],"uid"=>$database->getSQLParameter("clients","id",array("email"=>$email))));
						return 1;
					}
				}
			}
		}
		return 0;
	}
	
	public function proceedAdminAuthorize($data,$key)
	{
		$tools=&$GLOBALS['tools'];
		$database=&$GLOBALS['database'];
		$sessions=&$GLOBALS['sessions'];
		$result=false;
		if(is_array($data) && $tools->checkValues($data,array('a'))){
			$pin=join('',$data['a']);
			if($database->checkRowExists("users",array("pin"=>$pin,"status"=>"on"))){
				if(!$database->isError())
				{
					$d=$sessions->registerData("admin_auth",uniqid('i',true),array(time(),3600*2));
					$tid=$database->updateRow("users",array("laccess"=>time(),"ip"=>$_SERVER['REMOTE_ADDR']),array("key"=>$pin));
					$result=true;
				}
			}
		}
		return $result;
	}
	
	public function proceedEXTR($data)
	{
		if($GLOBALS['database']->checkRowExists("users",array("extr"=>$data)))
		{
			if($this->renewEXTR($data))
				return true;
		}
		return false;
	}
	
	function encr($string, $key)
	{
	  for($i=0; $i<strlen($string); $i++)
	    {
	      for($j=0; $j<strlen($key); $j++)
		{
		  $string[$i] = $string[$i]^$key[$j];
		}
	    }
	  return $string;
	}
	
	function decr($string, $key) {
	
	  for($i=0; $i<strlen($string); $i++)
	    {
	      for($j=0; $j<strlen($key); $j++)
		{
		  $string[$i] = $key[$j]^$string[$i];
		}
	    }
	  return $string;
	}
	
	function genkey($keylength, $cookiename)
	{
	  $rkey = substr(ereg_replace("[^A-Za-z0-9]",
				      "",
				      crypt(time())) .
			 ereg_replace("[^A-Za-z0-9]",
				      "",
				      crypt(time())) .
			 ereg_replace("[^A-Za-z0-9]",
				      "",
				      crypt(time())),
			 0, $keylength);
	  return $rkey;
	}
	
	function encdata($passwd, $rkey)
	{
	  $encpasswd = $this->encr(bin2hex($passwd),$rkey);
	  return $encpasswd;
	}
	
	
	function decdata($cipher, $rkey)
	{
	  $dechexpasswd = $this->decr($cipher, $rkey);
	  $decpasswd='';
	  for ($i=0; $i<strlen($dechexpasswd)/2; $i++) {
	    $decpasswd.=chr(base_convert(substr($dechexpasswd,$i*2,2),16,10));
	  }
	  return $decpasswd;
	}

}
?>