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
?>
<?php
class sessions implements sessionsI{

	private function checkExists($indefier){
		return $GLOBALS['database']->checkRowExists("sessions",array("name"=>$indefier,"client"=>$_SERVER['REMOTE_ADDR']));
	}

	public function terminate($indefier){
		$database=&$GLOBALS['database'];
		$result=false;
		$q=$database->proceedQuery("DELETE FROM `#prefix#_sessions` WHERE name='".$indefier."' AND client='".$_SERVER['REMOTE_ADDR']."'");
		if(!$database->isError()){
			$result=true;
		}
		return $result;
	}

	public function registerData($indefier,$value,$length=126000,$replace=false){
		$result=false;
		$database=&$GLOBALS['database'];
		if(is_array($length)) $length=$length[1];
			if($database->checkRowExists("sessions",array("name"=>$indefier,"client"=>$_SERVER['REMOTE_ADDR'])))
			{
				if($replace)
				{
					if($database->updateRow("sessions",array("body"=>$value,"start_time"=>time(),"length"=>$length),array("name"=>$indefier)))
					{
						$result=true;
					}
				}else{
					
					$result=true;
				}
			}
			if(!$result){
				if($database->insertRow("sessions",array('',$indefier,$value,time(),$length,$_SERVER['REMOTE_ADDR'])))
				{
					$result=true;
				}
			}
		return $result;
	}


	public function whenDie($name)
	{
		$database=&$GLOBALS['database'];
		$result=null;
		if(!$this->isDeath($name))
		{
			$q=$q=$database->proceedQuery("SELECT start_time,length FROM `#prefix#_sessions` WHERE name='".$name."' AND client='".$_SERVER['REMOTE_ADDR']."'");
			$row=$database->fetchQuery($q);
			$result=(($row['start_time']+$row['length'])-time());
		}
		return $result;
	}

	public function isDeath($indefier){
		$database=&$GLOBALS['database'];
		$result=true;
		if($this->checkExists($indefier)){
			$q=$database->proceedQuery("SELECT start_time,length FROM `#prefix#_sessions` WHERE name='".$indefier."' AND client='".$_SERVER['REMOTE_ADDR']."'");
			if(!$database->isError()){
				if($database->getNumrows($q)!=0)
				{
					$row=$database->fetchQuery($q);
					if((($row['start_time']+$row['length'])-time())>0){
						return false;
					}
				}
			}
		}
		return $result;
	}


	public function getData($indefier){
		$result=null;
		$database=&$GLOBALS['database'];
		$q=$database->proceedQuery("SELECT body FROM `#prefix#_sessions` WHERE name='".$indefier."' AND client='".$_SERVER['REMOTE_ADDR']."'");
		if(!$database->isError()){
			if($database->getNumrows($q)!=0)
			{
				$row=$database->fetchQuery($q);
				$result=$row['body'];
			}
		}
		return $result;
	}
}
?>
