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
class database implements databaseI{

	private $conn_id=null;
	private $_debug=0;
	private $sql_res=null;
	private $_sql_query=null;
	private $last_error=null;
	private $total_queryes=0;
	public $version=1;
	public $db_version=null;
	private $auth_info=array();

	function  __construct(){
		$system=&$GLOBALS['system'];
		$security=&$GLOBALS['security'];
		if(!$system){
			exit();
		}else{
			if($this->_debug){
				set_error_handler("system::_errorMsg");
			}
			$config=simplexml_load_string($security->decr(join('',file($system->getPath('packages').'/database/config.xml')),"dasdasdvdst23tgeb"));
			if(!$config){
				die("Please as first run 'install.php' script !");
			}else{
				for($i=0;$i<count($config->param);$i++)
				{
					$this->auth_info[(string)$config->param[$i]['name']]=(string)$config->param[$i]['value'];
				}
			}
		}
	}
	
	public function query2XML($array)
	{
		$data=null;
		if(is_array($array))
		{
			$data='<items>';
			for($i=0;$i<count($array);$i++)
			{
				$data.="<item id='".$i."'>";
				foreach ($array[$i] as $k=>$v)
				{
					$data.='<'.$k.'>'.$v.'</'.$k.'>';
				}
			}
			$data.='</items>';
		}
		return $data;
	}

	public function fillArrWithVal($array,$value)
	{
		$new_array=array();
		if(is_array($array) && count($array)>0)
		{
			for($i=0;$i<count($array);$i++)
			{
				$new_array[$array[$i]]=$value;
			}
		}
		return $new_array;
	}

	public function proceed_action($table,$data,$action)
	{
		if(is_array($data)){
			switch($action){
				case 'delete':#die_r(func_get_args());
				if(!$this->deleteRow($table,(!is_array($data[0]))?array($data[0]=>$data[1]):$this->fillArrWithVal($data[0],$data[1]))){
					die($this->sqlErrorString());
					return false;
				}
				break;
				case 'set_null':
					if(in_array("where",$data) && in_array("cols",$data) && count($data['cols'])==2 && count($data['where'])==2){
						if($this->updateRow(
													$table,
													$this->fillArrWithVal($data['cols'][0],$data['cols'][1]),
													$this->fillArrWithVal($data['where'][0],$data['where'][1])
													))
						{
							return true;
						}
					}
					break;
				case 'deny':
					if($this->_fieldExists($table,"status"))
					{
						if($this->updateRow($table,array("status"=>"off"),(!is_array($data[0]))?array($data[0]=>$data[1]):$this->fillArrWithVal($data[0],$data[1]))){
							return true;
						}
					}
					break;
				default:;
			}
		}
		return true;
	}

	/**
	 * Proceed changes to the array of tables ($linkable) what have pointers to the 
	 * table $foreign_key of the $base_table, if changes applies
	 * to $base_table
	 *
	 * @param String $base_table
	 * @param String $base_id
	 * @param Array $linkable
	 * @param Mixed $action
	 */
	public function proceedForeignKeys($base_table,$key,$key_value,$linkable=array(),$action='')
	{
		if(is_array($linkable) && $this->_tableExists($base_table) && $this->_fieldExists($base_table,$key))
		{
			if(is_array($linkable[0])){
				for($i=0;$i<count($linkable);$i++)
				{
					if($this->_tableExists($linkable[$i][0]) && $this->_fieldExists($linkable[$i][0],$linkable[$i][1]))
					{
						$z=$this->proceed_action($linkable[0][$i],array($linkable[1],$key_value),$action);
					}
				}
				if($z)return true;
			}else{
				$z=$this->proceed_action($linkable[0],array($linkable[1],$key_value),$action);
				if($z)return true;
			}
		}
		return false;
	}

	/**
	 * Check that $field exists in the $table
	 *
	 * @param String $table 
	 * @param mixed $field Can be array or string
	 * @return boolean
	 */
	public function _fieldExists($table,$field)
	{
		return true;
	}

	/**
	 * Check that $table exists
	 *
	 * @param String $table
	 * @return boolean
	 */
	public function _tableExists($table)
	{
		return true;
	}

	public function copyTables($table1,$table2,$where_clause)
	{
		
	}
	
	public function copyDatabase($database1,$database2,$tables=array(),$where_clause=array())
	{}

	public function copyRows($table,$key,$old_key_value,$new_key_value,$where_clause=array())
	{
	}
	/**
	 * Prepare fields list based on $data elements (using in the SELECT or UPDATE statments)
	 *
	 * @param Array $data
	 * @return String
	 */
	private function makeFieldsString($data)
	{
		$i=0;
		$fld='';
		if(is_array($data)){
			foreach($data as $k=>$v)
			{
				$i++;
				$fld.=$v;
				if($i<(count($data)))
				{
					$fld.=',';
				}
			}
		}else{
			$fld="*";
		}
		return $fld;
	}

	/**
	 * Prepare string to use in the LIMIT-statement
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	private function makeLimitString($data)
	{
		return (($data)?(is_array($data)?$data[0].','.$data[1]:$data):'');
	}

	/**
	 * Format where-clause string based on the $data elements and logical
	 * separator $type
	 *
	 * @param Array $data
	 * @param String $type
	 * @return String
	 */
	public function makeWhereString($data,$type="AND")
	{
		$where=null;
		$i=0;
		if(is_array($data) && count($data)>0)
		{
			$where='WHERE ';
			foreach($data as $k=>$v)
			{
				$i++;
				$where.=$k."='".$v."' ";
				if($i<(count($data)))
				{
					$where.=$type." ";
				}
			}
		}
		return $where;
	}

	/**
	 * Delete rows from $table whick applyed with $where_clause condition
	 * in the context of $where_type logical separator
	 *
	 * @param unknown_type $table
	 * @param unknown_type $where_clause
	 * @param unknown_type $where_type
	 * @return unknown
	 */
	public function deleteRow($table,$where_clause,$where_type="AND")
	{
		$result=false;
		if(!is_array($where_clause))
		{
			$result=DATABASE_WRONG_PARAM;
		}else{
			$query="DELETE FROM `#prefix#_".$table."`".$this->makeWhereString($where_clause,$where_type);
			$q=$this->proceedQuery($query);
			$result=!$this->isError();
		}
		return $result;
	}

	/**
	 * 
	 * @return 
	 * @param $table String  New of the source datatable
	 * @param $fields Array  Fields list
	 * @param $where Array[optional] Where-clause string
	 * @param $order String[optional]	Sorting order
	 * @param $limitation Boolean[optional]	Limitation of resulted corteges
	 */
	public function getRows($table,$fields,$where=1,$order=false,$limitation=false){
		if(trim($table)!='' && ($fields=='*' || is_array($fields)) && ($where==1 || is_array($where))){
			$ord=(trim($order)!='')?'ORDER BY `'.$order.'`':'';
			$query=sprintf("SELECT %s FROM `#prefix#_%s` %s %s %s",
			$this->makeFieldsString($fields),
			$table,
			$this->makeWhereString($where),
			$ord,
			$this->makeLimitString($limitation)
			);
			#print_r($query);
			$q=$this->proceedQuery($query);
			if($this->isError()){
				$result=0;
			}else{
				$result=$q;
			}
		}
		return $result;
	}

	/**
	 * Apply changes based on $updates to the $rows which applyed
	 * with $where_clause condition in the context of $where_type
	 * logical separator
	 *
	 * @param String $table
	 * @param Array $updates
	 * @param Array $where_clause
	 * @param String $where_type
	 * @return boolean
	 */
	public function updateRow($table,$updates,$where_clause=1,$where_type="AND"){
		$upd='';
		$i=0;

		foreach($updates as $k=>$v){
			$i++;
			$upd.=$k."=".((is_numeric($v))?mysql_real_escape_string($v):'\''.mysql_real_escape_string($v).'\'');
			if($i<(count($updates))){
				$upd.=',';
			}
		}
		$query="UPDATE `#prefix#_".$table."` SET ".$upd." ".$this->makeWhereString($where_clause);
		#die($query);
		#return $result;
		$q=$this->proceedQuery($query);
		$result=!$this->isError();
		return $result;
	}

	/**
	 * Get returned results by the pointer to query to database $q
	 *
	 * @param resource $q
	 * @return Array
	 */
	public function fetchQuery($q){
		$result=($q && is_resource($q))?mysql_fetch_array($q): NULL;
		return $result;
	}
	
	public function _setConnection($data,&$reference=null)
	{
		$result=false;
		if(in_array("passwd",$data) && in_array("user",$data) && in_array("host",$data) && in_array("db",$data))
		{
			$reference=@mysql_connect(($data['host'].(in_array("port",$data)?":".$data['port']:'')),$data['user'],$data['passwd']);
			if(!$reference)
			{
				$result=true;
				@mysql_select_db($data['db'],$reference);
			}
		}
		return $result;
	}

	/**
	 * Set connection to the database
	 *
	 */
	public function setConnection(){
		if($this->checkConnection()!=DATABASE_CONNECTION_ESTABILISHED){
			$this->propertySet("conn_id",@mysql_connect($this->auth_info['dbhost'],$this->auth_info['dbuser'],$this->auth_info['dbpasswd']));
			if(!$this->isError()){
				$this->propertySet('sql_res',@mysql_select_db($this->auth_info["dbname"],$this->getProperty('conn_id')));
				$this->proceedQuery("SET NAMES utf8");
			}
		}
	}

	/**
	 * Get array of all happened errors during this session
	 *
	 * @param Integer $count
	 * @return Array
	 */
	public function getErrorsList($count=2){
		$this->temp['_errors']=$this->getProperty('_errors');
		$this->temp['_result']=array();
		if(count($this->temp['_errors'])!=0){
			for($i=0;$i<$count;$i++){
				$this->temp['_result'][]=$this->temp['_errors'][$i];
			}
		}else{
			return array();
		}
		return $this->temp['_result'];
	}

	/**
	 * Get value of last database error in this session
	 *
	 * @return String
	 */
	public function sqlErrorString(){
		return $this->getLastError();
	}

	/**
	 * Get fields list of the $table
	 *
	 * @param String $table
	 * @return Array
	 */
	public function getTableFields($table)
	{
		$result=array();
		$scheme=$this->getRows($table,"*",1);
		#die(print_r($scheme));
		$i=0;
		while($i<@mysql_num_fields($scheme))
		{
			$meta=@mysql_fetch_field($scheme,$i);
			$result[]=array('name'=>$meta->name,'type'=>$meta->type);
			$i++;
		}
		return array('data'=>$result,'count'=>@mysql_num_fields($scheme));
	}
	
	public function lastQuery()
	{
		return $this->_sql_query;
	}

	/**
	 * Insert new row to the $table based on the $data elements
	 *
	 * @param String $table
	 * @param Array $data
	 * @return Integer
	 */
	public function insertRow($table,$data){
		$query="INSERT into `#prefix#_".$table."` ";
		$fs=$this->getTableFields($table);
		$fields=$fs['data'];
		$count=$fs['count'];
		$i=0;
		$fscheme='(';
		$scheme='';
		foreach($fields as $k=>$v)
		{
			if($v['name']!='id'){
				$scheme.=($v['type']=='blob' || $v['type']=='string')?'\'':'';
				$scheme.=addslashes($data[$i]);
				$scheme.=($v['type']=='blob' || $v['type']=='string')?'\'':'';
				$scheme.=($i<($fs['count']-1))?',':'';
				$fscheme.='`'.$v['name'].'`';
				$fscheme.=($i<($fs['count']-1))?',':'';
			}else{
				$scheme.="LAST_INSERT_ID(id),";
				$fscheme.='`id`,';
			}
			$i++;
		}
		$query.=$fscheme.') VALUES('.$scheme.')';
		$q=$this->proceedQuery($query);
		if($q)
		{
			return mysql_insert_id($this->conn_id);
		}else{
			return false;
		}
	}

	/**
	 * Check is the $table content rows (
	 *
	 * @param unknown_type $table
	 * @param unknown_type $rows
	 * @param unknown_type $where_type
	 * @param unknown_type $limitation
	 * @return unknown
	 */
	public function checkRowExists($table,$rows="",$where_type="AND",$limitation=true){
		$query=sprintf("SELECT id FROM `#prefix#_%s` %s LIMIT %s",
		$table,
		$this->makeWhereString($rows),
		($limitation)?1:'');
		$q=$this->proceedQuery($query);
		if(!$this->isError()){
			if($this->getNumrows($q)!=0)
			{
				$d=$this->fetchQuery($q);
				return array("status"=>"ok","id"=>$d['id']);
			}
		}
		return 0;
	}

	private function getLastError(){
		return @mysql_error();
	}

	public function getProperty($property,$class=null){
		if(!is_array($property)){
			if(!$class)
			$result=(in_array($property,get_class_vars(get_class($this))))?$this->$property:DATABASE_PROPERTY_NOT_EXISTS;
			else
			$result=(in_array($property,get_class_vars(get_class($class))))?$$class->${$property[0]}[$property[1]]:DATABASE_PROPERTY_NOT_EXISTS;
		}else{
			$result=array();
			$class=($class && $class!=null)?$class:'this';
			foreach($property as $k=>$v){
				$property_exists=($class!='this')?in_array($k,get_class_vars(get_class($class))):isset($this->$k);
				if($property_exists){
					$result=array();
					foreach($property[$k] as $c=>$d){
						$result[$d]=$$class->{$k}[$d];
					}
				}else{
					$result[$k]=DATABASE_PROPERTY_NOT_EXISTS;
				}
			}
		}
		return $result;
	}

	public function isError(){
		return (mysql_error()=='' && $this->_conn_id);
	}

	public function closeConnection(){
		return (($this->getConnId()!==false)?(@mysql_close($this->getConnId()) && $this->propertySet('conn_id',null)):DATABASE_CONNECTION_NOT_SET);
	}

	public function proceedQuery($query){
		$this->setConnection();
		$this->sql_res=null;
		$query=str_replace('#prefix#',$this->auth_info['prefix'],$query);
		if(trim($query)!=''){
			$this->_sql_query=$query;
			$this->sql_res=@mysql_query($query,$this->getConnId());
		}	
		return $this->getProperty("sql_res");
	}

	public function checkConnection(){
		return(($this->getProperty("conn_id")==true)?DATABASE_CONNECTION_ESTABILISHED:DATABASE_CONNECTON_NOT_SET);
	}

	public function getNumrows($q){
		$result=false;
		if($q){
			if(is_resource($q)){
				$result=@mysql_num_rows($q);
			}else{
				$result=$this->proceedQuery("SELECT COUNT(*) AS count FROM `#prefix#_".$q."`");
				$result=$this->fetchQuery($result);
				$result=$result['count'];
			}
		}
		return $result;
	}

	public function getSQLParameter($table,$col,$where=''){
		$this->_result='';
		$qStamp='';
		$col=is_array($col)?join(',',$col):$col;
		$query=sprintf('SELECT %s FROM `#prefix#_%s` %s',$this->makeFieldsString($col),$table,$this->makeWhereString($where));
		#print_r($query);
		$q=$this->proceedQuery($query);
		if(!$this->isError()){
			if($this->getNumrows($q)!=0){
				$row=$this->fetchQuery($q);
				$this->_result=$row[$col];
			}else{
				$this->_result=-1;
			}
		}else{
			$this->_result=-1;
		}
		return $this->_result;
	}

	public function getConnId(){
		return $this->getProperty('conn_id');
	}
	
	public function getNumcols($query_id){}

	public function getInstance(){
	}

	public function propertySet($var,$value,$class=null){
		if(!$class){
			$this->$var=$value;
		}else{
			if(class_exists($class)){
				$class->$var=$value;
			}else{
				return false;
			}
		}
		return true;
	}

}
?>
