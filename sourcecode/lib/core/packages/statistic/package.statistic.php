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
class statistic implements istatistic
{
	
	private function _uniqued()
	{
		$database=$GLOBALS['database'];
		return $database->checkRowExists("temp",array("name"=>"st_visitor_ssx2","body"=>$_SERVER['REMOTE_ADDR']));
	}
	
	private function _is_affilate()
	{
		if(in_array("HTTP_REFERER",$_SERVER) && $_SERVER['HTTP_REFERER']!='')
		{
			//NEED FIX: add field "params" to `#prefix#_texts` 
			//to indicate who owner of the site what user came from
			if($database->checkRowExists("texts",array("partition"=>"shop_affilates_ssa4","value"=>$_SERVER['HTTP_REFERER']))){
				return $database->getSQLParameter("texts","param",array("partition"=>"shop_affilates_ssa4","value"=>$_SERVER['HTTP_REFERER']));	
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	
	public function visitor(){
		$this->update_stats();
		if(false!==($a=$this->_is_affilate())){
			$this->remeber_a($a);
			$this->update_affilate($a);
		}	
	}
	
	public function getParam($name)
	{
		$database=$GLOBALS['database'];
		return $database->getSQLParameter("stats",$name);
	}
	
	public function clearTemps(){}
	
	private function update_affilate($id,$type)
	{
		$database=$GLOBALS['database'];
		$result=false;
		if($id && is_numeric($id) && $database->checkRowsExists('affilates',array('id'=>$id))){
			$update=array();
			switch($type)
			{
				case 'visitor':$update[0]='visitors';$update[1]="visitors+1";break;
				case 'order':$update[0]='orders';$update[1]='orders+1';break;
				case 'registrant':$update[0]='registrants';$update[1]='registrants+1';break;
			}
			$result=$database->updateRows("affilates",array($update[0]=>$update[1],array("id"=>$id)));
		}
		return $result;
	}
	
	private function update_stats()
	{
		$database=$GLOBALS['database'];
		$this->remember_v();
		$q=$database->proceedQuery("UPDATE `#prefix#_stats` SET visitors=visitors+1, ".(($this->_uniqued())?'uniqued+1':'uniqued'));
	}
	
	private function remember_v(){
		$database=$GLOBALS['database'];
		$tid=$database->insertRow("temp",array("st_visitor_ssx2",$_SERVER['REMOTE_ADDR']));
		return (($database->isError())?0:$tid);
	}
	
	private function remeber_a($aid)
	{
		$database=$GLOBALS['database'];	
		$aid=$database->insertRow("texts",array("","shop_affilates_ssa4",$_SERVER['REMOTE_ADDR'],$aid));
		return ($database->isError()?true:false);
	}
	
}
?>