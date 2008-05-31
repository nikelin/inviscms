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
class basket
{
	public function clear_basket($uid)
	{
		return $GLOBALS['database']->deleteRow("basket",array("client"=>$uid));
	}
	
	public function add($id,$count,$type,$size='S',$format='A4'){
		$database=&$GLOBALS['database'];
		$clients=&$GLOBALS['clients'];
		$tools=&$GLOBALS['tools'];
		$result=false;
		$client=$clients->getUID();
		if($database->checkRowExists("basket",array("client"=>$client,"pid"=>$tools->getGoodID($id,6)))){
			$q=$database->proceedQuery("UPDATE `#prefix#_basket`
											SET count=count+".$count."
											WHERE client='".$client."' AND pid='".$tools->getGoodID($id,6)."'
											");
		}else{
			$q=$database->insertRow("basket",array("",$tools->getGoodID($id,6),$type,$size,$format,$count,$client,time()));
			#die_r($tools->getGoodID($id,6));
		}
		
		if(!$database->isError()){
			$result=true;
		}
		return $result;
	}
	
	public function remove($uid,$pid){
		$database=&$GLOBALS['database'];
		$result=false;
		if($database->checkRowExists("basket",array('client'=>$uid,'LEFT(MD5(id),6)'=>$pid)))
		{
			if($database->deleteRow("basket",array("client"=>$uid,"LEFT(MD5(id),6)"=>$pid)))
			{
				$result=true;
			}
		}
		return $result;
	}
	
	public function updateCount($client,$pid,$count,$op)
	{
		$database=&$GLOBALS['database'];
		$q=$database->proceedQuery("UPDATE `#prefix#_basket` SET count=count".($op=='plus')?'+':'-'.$count." WHERE id=".$pid." AND client='".$client."'");
		return(!$database->isError());
	}
	
	public function totalCost($uid){
		$database=&$GLOBALS['database'];
		$result=0;
		$q=$database->proceedQuery("SELECT id,pid,count AS bcount,
									(SELECT SUM(price*bcount) AS cost FROM `#prefix#_catalog` WHERE id=pid) AS cost
									FROM `#prefix#_basket`
									WHERE client='".$uid."'");
		if(!$database->isError()){
			if($database->getNumrows($q)!=0)
			{
				while($data=$database->fetchQuery($q))
				{
					$result+=$data['cost'];
				}
			}
		}
		return $result;
	}
	
	public function itemsCount(){
		$database=&$GLOBALS['database'];
		$clients=&$GLOBALS['clients'];
		$uid=$clients->getUID();
		$q=$database->proceedQuery("SELECT SUM(count) AS count FROM `#prefix#_basket` WHERE client='".$uid."'");
		if(!$database->isError($q))
		{
			if($database->getNumrows($q)!=0)
			{
				$result=$database->fetchQuery($q);
				$result=$result['count'];
			}
		}
		return $result;
	}
	
	public function itemsList($uid)
	{
		
	}
	
	public function moveItems($old_uid,$current_uid)
	{
		return $GLOBALS['database']->updateRows("basket",array("client"=>$current_uid),array("client"=>$old_uid));
	}
}
?>