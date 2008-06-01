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
class tools{
	private $temp=array();
	private $_wrappers=array();

	function __construct(){
	}

	public function isEmail($str)
	{
		return preg_match('/[a-zA-Z0-9_\-]*[\@]+([a-zA-Z0-9_\-]*\.+){1,}/',$this->decodeString($str));
	}
	
	public function isURL($str)
	{
		return preg_match('/(?:http\:\/\/)*(www\.)?([a-zA-Z0-9_\-]*\.+){1,}[\/]?/',$this->decodeString($str));
	}
	
	public function isPhone($str)
	{
		$str=$this->decodeString($str);
		return(preg_match('/(\+)?[\s]*[0-9]{1,3}[\s]*\([0-9]{1,5}\)[\s]*[0-9\-]{5,9}/',$str)
				|| preg_match('/\([0-9]{1,5}\)[\s]*[0-9\-]{5,9}/',$str)
				|| preg_match('/[0-9\s]{10,20}/',$str));
	}


	public function pageExists($id){
		$database=$GLOBALS['database'];
		return $database->checkRowExists("pages",array((is_string($indefier)?"ufu":"id")=>$indefier,'status'=>'on'));
	}


	public function getGoodID($hash,$hash_length)
	{
		$database=&$GLOBALS['database'];
		return $database->getSQLParameter("catalog","id",array("LEFT(MD5(id),".$hash_length.")"=>$hash));
	}

	public function translit($str,$way=1)
	{
		$dict=array("щ"=>"sch","ш"=>"sh","ц"=>"ts","ч"=>"ch","я"=>"ya","ю"=>"yu","й"=>"yi","ё"=>"yo",
		"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","e"=>"ye",
		"ж"=>"j","з"=>"z","и"=>"i","к"=>"k","л"=>"l","м"=>"m",
		"н"=>"n","п"=>"p","р"=>"r","у"=>"u","с"=>"s","о"=>"o","т"=>"t","ф"=>"f","х"=>"h",
		"ь"=>"'","ъ"=>"","ы"=>"y","э"=>"e","і"=>"i",
		"Щ"=>"sch","Щ"=>"sh","Я"=>"Ya","Ц"=>"ts","Ч"=>"ch","Ю"=>"yu","Й"=>"yi","Ё"=>"yo",
		"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"YE",
		"Ж"=>"J","Э"=>"Z","И"=>"I","К"=>"K","Л"=>"L","М"=>"M",
		"Н"=>"N","П"=>"P","Р"=>"R","У"=>"U","С"=>"S","О"=>"O","Т"=>"T","Ф"=>"F","Х"=>"H",
		"Ь"=>"'","Ъ"=>"","Ы"=>"Y","Э"=>"E","І"=>"I",
		" "=>"_","-"=>"_");
		foreach($dict as $k=>$v){
			if($way){
				$str=str_replace($k,$v,$str);
			}else{
				$str=str_replace($v,$k,$str);
			}
		}
		return $str;
	}


	public function getEnvVars($env,$enc=false){
		switch($env){
			case 'GET':
				$env=$_GET;
				break;
			case 'POST':
				$env=$_POST;
				break;
			case 'SERVER':
				$env=$_SERVER;
				break;
			default:
				return false;
				break;
		}
		if($enc){
			$env=$this->encodeArrayData($env);
		}

		return $env;
	}

	public function checkValues($array,$important){
		foreach($array as $k=>$v){
			if(!is_array($v)){
				if((is_array($important) && in_array($k,$important)) || $important=='all'){
					if(trim($v)==''){
						return false;
					}
				}
			}else{
				return ($this->checkValues($v,$important));
			}
		}
		return true;
	}

	public function isRawEncoded($str){
		return(preg_match('/([%]+[a-fA-F0-9\=]{2,2}){1,}/',$str)==true);
	}

	public function decodeString($str){
		while($this->isRawEncoded($str)==1){
			$str=rawurldecode($str);
		}
		return $str;
	}

	public function decodeArrayData($data){
		if(is_array($data)){
			foreach($data as $k=>$v){
				if(!is_array($v)){
					$data[$k]=$this->decodeString($data[$k]);
					# print($v.'::'.rawurlencode($v).'::'.rawurldecode(rawurlencode($v)).'<br/>');
				}else{
					$data[$k]=$this->decodeArrayData($v);
				}
			}
		}
		return $data;
	}

	public function encodeArrayData($data){
		$ready=array();
		if(is_array($data)){
			foreach($data as $k=>$v){
				if(!is_array($v) && !in_array(md5($v),$ready)){
					$ready[]=md5($v);
					$data[$k]=rawurlencode($v);
					# print($v.'::'.rawurlencode($v).'::'.rawurldecode(rawurlencode($v)).'<br/>');
				}else{
					$data[$k]=$this->encodeArrayData($v);
				}
			}
		}
		return $data;
	}

	public function getFilesCount($cwd){
		$dir=opendir($cwd.'lib/files');
		$i=0;
		while(false!==($file=readdir($dir))){
			if($file!='..' && $file!='.'){
				$i++;
			}
		}
		return $i;
	}

	public function getFileTotalSize($cwd){
		$dir=opendir($cwd.'lib/files');
		$size=0;
		while(false!==($file=readdir($dir))){
			if($file!='..' && $file!='.'){
				$size+=filesize($cwd.'lib/files/'.$file);
			}
		}
		return $size;
	}

	public function pasteDateForm()
	{
		$this->temp['_data']="<Table>";
		$this->temp['_data'].="<tr><td>";
		$this->temp['_data'].="<select name=\"d\">";
		for($i=31;$i>=1;$i--){
			$this->temp['_data'].="<option value=\"".$i."\"";
			if($i==date("d")){
				$this->temp['_data'].="selected";
			}
			$this->temp['_data'].=">".$i."</option>";
		}
		$this->temp['_data'].="</select></td>";
		$this->temp['_data'].="<td>";
		$this->temp['_data'].="<select name=\"m\">";
		for($i=12;$i>=1;$i--){
			$this->temp['_data'].="<option value=\"".$i."\"";
			if($i==date("m")){
				$this->temp['_data'].= "selected";
			}
			$this->temp['_data'].=">".$i."</option>";
		}
		$this->temp['_data'].="</select></td>";
		$this->temp['_data'].="<td>";
		$this->temp['_data'].="<select name=\"y\">";
		for($i=2039;$i>=1940;$i--){
			$this->temp['_data'].="<option ";
			if($i==date("Y")){
				$this->temp['_data'].="selected";
			}
			$this->temp['_data'].=" value=\"".$i."\">".$i."</option>";
		}
		$this->temp['_data'].="</select>";
		$this->temp['_data'].="</td></tr>";
		$this->temp['_data'].="</table>";
		return $this->temp['_data'];
	}

	public function getFiles($start_dir='.') {
		$files = array();
		if (is_dir($start_dir)) {
			$fh = opendir($start_dir);
			while (($file = readdir($fh)) !== false) {
				# loop through the files, skipping . and .., and recursing if necessary
				if (strcmp($file, '.')==0 || strcmp($file, '..')==0) continue;
				$filepath = $start_dir . '/' . $file;
				if ( is_dir($filepath) )
				$files = array_merge($files, $this->getFiles($filepath));
				else
				array_push($files, $filepath);
			}
			closedir($fh);
		} else {
			# false if the function was called with an invalid non-directory argument
			$files = false;
		}

		return $files;

	}
	

	public function buildList($type,$name,$data,$select=array(),$params=array()){
		$result=null;
		$database=&$GLOBALS['database'];
		$where=array_key_exists('where',$data);
		if(!is_array($data)){
			$result= false;
		}else{
			if(array_search('datasource',$data)==-1 || array_search('value',$data)==-1 || array_search('label',$data)==-1){
				$result=false;
			}else{
				#die_r($where);
				$q=$database->getRows($data['datasource'],array($data['value'],$data['label']),($where)?$data['where']:1);
				if(!$database->isError() && $database->getNumrows($q)!=0){
					$result='';
					switch($type){
						case 'div':
							break;
						case 'select':
							$result.='<select name="'.$name.'" style="width:100%;font-size:13px;font-weight:bold;">';
							/**die_r($params);
							if($params['default'])
							{
								$result.="<option value='".$params['default']."'></option>";
							}**/
							$result.="<option value='-1'>&nbsp;</option>";
							while(false!==($row=$database->fetchQuery($q))){
								$s=(is_array($select) && array_key_exists("value",$select) && $select['value']==$row[$data['value']])?"selected":"";
								$result.='<option value="'.$row[$data['value']].'" '.$s.'>'.$this->decodeString($row[$data['label']]).'</option>';
							}
							$result.='</select>';
							break;
						default:
					}
				}else{
					return false;
				}
			}
		}
		return $result;
	}
	
	public function stripslashes_deep($value) {
		if (is_array($value)) {
		    if (count($value)>0) {
			$return = array_combine(array_map('stripslashes_deep', array_keys($value)),array_map('stripslashes_deep', array_values($value)));
		    } else {
			$return = array_map('stripslashes_deep', $value);
		    }
		    return $return;
		} else {
		    $return = stripslashes($value);
		    return $return ;
		}
	}


	public function postfetchProceed($data,$wrappers=null)
	{
		$sape_client=&$GLOBALS['sape_client'];
		if(preg_match_all("/\[advertising\:([0-9]*)\]/",$data,$matches))
		{
				for($i=0;$i<count($matches[1]);$i++)
				{
					$c=$matches[1][$i];
					$data=str_replace('[advertising:'.$c.']',$sape_client->return_links($c),$data);
				}
		}
		return $data;
	}
	
	public function registerWrapper($module,$wrapper)
	{
		if(is_array($module))
		{
			for($i=0;$i<count($module);$i++)
			{
				$this->registerWrapper($module[$i],$wrapper);
			}
		}else
		{
			if(!array_key_exists($module,$this->_wrappers))
			{
				$this->_wrappers[$module]=array();
			}
			if(is_array($wrapper))
			{
				for($i=0;$i<count($wrapper);$i++)
				{
					$this->_wrappers[$module][]=$wrapper[$i];
				}
			}else
			{
				$this->_wrappers[$module][]=$wrapper;
			}
		}
	}
	
	public function getWrappers($module)
	{
		if(array_key_exists($module,$this->_wrappers))
		{
			return $this->_wrappers[$module];
		}
	}
	
	public function applyWrappers($module,$data)
	{
		if(array_key_exists($module,$this->_wrappers))
		{
			for($i=0;$i<count($this->_wrappers[$module]);$i++)
			{
				$data=call_user_func($this->_wrappers[$module][$i],$data);
			}
		}
		return $data;
	}
}
?>