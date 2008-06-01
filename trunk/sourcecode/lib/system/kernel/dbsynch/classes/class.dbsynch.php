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
class dbsynch
{
	private $source=null;
	private $target=null;
	private $rules=array();
	
	function __construct()
	{
		if(!isset($GLOBALS['database']))
		{
			return false;
		}else{
			$this->source=array("path"=>null,"conn"=>null,"info"=>array());
			$this->target=array("path"=>null,"conn"=>null,"info"=>array());
		}
	}
	
	
	function _parse_conn_info($data)
	{
		$result=null;
		if(is_array($data))
		{
			$result=$data;
		}else
		{
			$result=explode("::",$data);
			die_r($result);
			$result=array("host"=>$result[0],"port"=>$result[1],"user"=>$result[2],'passwd'=>$result[3],'db'=>$result[4]);
		}
		return $result;
	}
	
	/**
	 * Initialize synchronizing process between $source-database and $target-database
	 * In a case, when $taget-database is not exists, system do not start synchronizition,
	 * but create new database and copy contents of $source to new database.
	 * 
	 * Example: 1) dbsynch::init("localhost:3374::root::d12345::ax","132.45.65.1:3374::root::ajU_dFW::ax")
	 * Example: 2) dbsynch::init(
	 * 							array("host"=>"localhost","port"=>3374,user=>"root","passwd"=>"","db"=>"ax"),
	 * 							array("host"=>"127.0.0.2","port"=>3374,"user"=>"root","passwd"=>"","db"=>ax")
	 * 							);
	 * @return bool
	 * @param $source (String|Array)
	 * @param $target (String|Array)
	 */
	function init($source,$target)
	{
		$database=&$GLOBALS['database'];
		$result=false;
		$this->source['path']=$this->_parse_conn_info($source);
		$this->target['path']=$this->_parse_conn_info($target);
		if($database->_setConnection($this->source['path'],&$this->source['conn']) && $database->_setConnection($this->target['path'],&$this->target['conn']))
		{
			if($this->_get_db_info(array($this->source,$this->source['info']),array($this->target,$this->target['info'])))
			{
				return true;
			}
		}
		return $result;
	}
	
	function db_info($type="source")
	{
		return $this->$type['info'];
	}
	
	function _get_db_info($conn)
	{
		$result=false;
		$database=&$GLOBALS['database'];
		for($i=0;$i<count(func_num_args());$i++)
		{
			$conn=func_get_arg($i);
			if(is_resource($conn[0]))
			{
				$conn[1]['tbls']=array();
				$q=$database->proceedQuery("SHOW TABLES",$conn[0]);
				die_r($q);
			}
		}
	}
	
	
	
	/**
	 * Set action-rule
	 * 
	 * Example:
	 * 	$term="not_in_list_tables", $action=["drop"|"save"|"stop"]
	 * 	$term="not_in_list_cols", $action=["drop"|"save"|"stop"]
	 * @return 
	 * @param $term Object
	 * @param $action Object
	 */
	function set_rule($term,$action){}
	
	/**
	 * Get all differs between source and target databases. Scope - tables list.
	 * Example:
	 * 	  [0=>"tbl1 not in least of `db1` tables",1=>"source.tbl1 has some differs between target.tbl1"]
	 * 
	 * @return 
	 * @param $source String
	 * @param $target String
	 */
	function compare_dbs($source,$target){}
	
	/**
	 * Get all differs between source and target tables. Scope - columns list.
	 * @return 
	 * @param $source Object
	 * @param $target Object
	 */
	function compare_tbls($source,$target){}
	
	/**
	 * Get tables count from $where-source
	 * @return 
	 * @param $where Object[optional]
	 */
	function tbl_count($where="target"){}//$where=['target'|'source']
	function synch($type="test"){}//$type=['test'|'realtime']
	function get_cols($where="target",$tbl){}//
}
?>
