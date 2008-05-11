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
		$database=&$GLOBALS['database'];
		return $database->checkRowExists("sessions",array("name"=>$indefier));
	}

	public function terminate($indefier){
		$database=&$GLOBALS['database'];
		$result=false;
		$q=$database->proceedQuery("DELETE FROM `#prefix#_sessions` WHERE name='".$indefier."'");
		if(!$database->isError()){
			$result=true;
		}
		return $result;
	}

	public function registerData($indefier,$value,$time=array(),$replace=false){
		$result=false;
		$database=&$GLOBALS['database'];
		
		if(is_array($time) && count($time)==2 && (($time[0]+$time[1])!=time())){
			list($start_time,$length)=$time;
			if($database->checkRowExists("sessions",array("name"=>$indefier)))
			{
				if($replace)
				{
					if($database->updateRow("sessions",array("body"=>$value,"start_time"=>$start_time,"length"=>$length),array("name"=>$indefier)))
					{
						$result=true;
					}
				}else{
					$result=true;
				}
			}
			if(!$result){
				if($database->insertRow("sessions",array('',$indefier,$value,$start_time,$length,$_SERVER['REMOTE_ADDR'])))
				{
					$result=true;
				}
			}
		}
		#die_r($database->sqlErrorString());
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
		#die($indefier);
		if($this->checkExists($indefier)){
			$q=$database->proceedQuery("SELECT start_time,length FROM `#prefix#_sessions` WHERE name='".$indefier."' AND client='".$_SERVER['REMOTE_ADDR']."'");
			# die($database->sqlErrorString());
			if(!$database->isError()){
				if($database->getNumrows($q)!=0)
				{
					$row=$database->fetchQuery($q);
					#die_r((($row['start_time']+$row['length'])-time())>0);
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
