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
class system
{
	private $_paths=array(
			      'modules'=>'/lib/modules',
			      'abstractions'=>'/lib/core/abstractions',
			      'packages'=>'/lib/core/packages',
			      'interfaces'=>'/lib/core/interfaces',
			      'errors'=>'/lib/core/errors',
				  'libs'=>'/lib/core/others',
				  'files'=>'/lib/files'
			      );
				  
	private $loadings=array();
	
	public $instances=array();
	
	private $to_include=array();
	
	private $inclusion_path='';
	
	private $_defaultLibs=array();

	/**
	 * Append error event $eid to the class $namespace runtime environment
	 *
	 * @param unknown_type $namespace
	 * @param unknown_type $eid
	 * @return unknown
	 */
	function setError($namespace,$eid){
		 if(!isset($$namespace)){
			 return false;
		 }else{
			 if(!isset($$namespace->_errs)){
				 $$namespace->_errs=array($eid);
			 }else{
				 $$namespace->_errs[]=$eid;
			 }
		 }
	}
	
	
	/**
	 * Convert url to the Human Understands Address
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	function convertURL2HUA($data)
	{
		$params=array();
		if($data!='/' && trim($data)!=''){
			$pieces=explode('/',$data);
			$params['mod']=$pieces[0];
			$params['params']=(count($pieces)>1)?array_slice($pieces,1):array();
		}else{
			$params['mod']='home';
			$params['params']='';
		}
		return $params;
	}
	
	public function registeredPackage($package)
	{
		return in_array($package,$this->instances);
	}
	
	
	public function deniedPackage($indefier)
	{
		$d=@simplexml_load_file($this->getPath('packages').'/'.$indefier.'/info.xml');
		return ($d->status["value"]=='denied' || $d->status['value']=='off');
	}
	/**
			     * Load system module
			     *
			     * @param   string  $module
			     * @param   string $0age
			     * @return string
			     */
	public function registerPackage($indefier){
		#die($this->getPath('packages').'/'.$indefier.'/package.'.$indefier.'.php');
		if(!$this->deniedPackage($indefier) && file_exists($this->getPath('packages').'/'.$indefier.'/package.'.$indefier.'.php')){
			if(!in_array($indefier,$this->to_include)){
				$this->to_include[]=$indefier;
			}
		}else{
			return false;
		}
		return true;
	}
	
	/**
	 * Include package to runtime environment
	 *
	 * @param unknown_type $indefier
	 * @return unknown
	 */
	private function includePackage($package){
		if(trim($package)!=''){
				$pack=$this->getPath('packages').'/'.$package.'/package.'.$package.'.php';
				if(!file_exists($pack)){
					return 0;
				}else{
					if(include_once($pack)){
						$this->instances[]=$package;
						if(class_exists($package)){
							if(!isset($GLOBALS[$package]))
								$GLOBALS[$package]=new $package();
						}
					}else
					{
						die("Error!");
					}
				}
		}else{
			return 0;
		}
		return 1;
	}
	
	/**
	 * Return path to the system internals
	 *
	 * @param String $part
	 * @return Void
	 */
	public function getPath($part){
		return $this->_paths[$part];
	}
	
	public function setPath($part,$value){
		$this->_paths[$part]=$value;
	}
	
	/**
	 * Constructor
	 *
	 * @param String $path
	 */
	function __construct($path='./',$autoload=false){
		foreach($this->_paths as $k=>$v){
			$this->_paths[$k]=getcwd().$this->_paths[$k];
		}
	}
	
	public function autoLoad($mode="auto"){
		if(count($this->_defaultLibs)==0 || $mode=="auto"){
			$dir=opendir($this->getPath('packages'));
			while(false!==($d=@readdir($dir))){
				#print_rbr($d);
				$path=$this->getPath('packages').'/'.$d;
				if(is_dir($path) && file_exists($path.'/info.xml') && $d!='.' && $d!='..'){
					$z=$this->registerPackage($d);	
				}else{
					continue;
				}
			}
		}elseif(count($this->_defaultLibs)!=0 && $mode!="auto")
		{
			for($i=0;$i<count($this->_defaultLibs);$i++)
			{
				$this->registerPackage($this->_defaultLibs[$i]);	
			}
		}
		#die_r($this->to_include);
		return $this->loadLibs();
	}
	
	private function includeAbstractions($package){
		$d=$this->getDependencies($package,"abstractions");
		if($d && count($d)!=0){
			for($i=0;$i<count($d);$i++){
				$member=$this->getPath('abstractions').'/'.$d[$i].'/abstractions.'.$d[$i].'.php';
				if(!file_exists($member) || !@include_once($member)) return false;
			}
		}
		return true;
	}
	
	private function includeLibs($package)
	{
		$d=$this->getDependencies($package,"libs");
		#print_r($d);
		if($d && count($d)!=0){
			for($i=0;$i<count($d);$i++){
				$member=$this->getPath('libs').'/'.$d[$i].'.php';
				if(!file_exists($member) || !@include_once($member)) continue;
			}
		}
	}
	
	private function checkExtending($package)
	{
		$d=$this->getDependencies($package,"extending");
		if($d && count($d)!=0)
		{
			for($i=0;$i<count($d);$i++)
			{
				if(!$this->registeredPackage($d[$i]))
				{
					$this->loadOneLib($d[$i]);
				}
			}
		}
	}
	
	private function includeInterfaces($package)
	{
		$d=$this->getDependencies($package,"interfaces");
		if($d && count($d)!=0){
			for($i=0;$i<count($d);$i++){
				$member=$this->getPath('interfaces').'/'.$d[$i].'/interfaces.'.$d[$i].'.php';
				#print_rbr($member);
				if(!file_exists($member) || !include_once($member))return false;
			}
		}
		return true;
	}
	
	private function includeErrors($package)
	{
		$d=$this->getDependencies($package,"errors");
		if($d && count($d)!=0){
			for($i=0;$i<count($d);$i++){
				$member=$this->getPath('errors').'/'.$d[$i].'/errors.'.$d[$i].'.php';
				if(!file_exists($member) || !@include_once($member)) return false;
			}
		}
		return true;
	}
	
		
	private function getDependencies($package,$part){
		$path=$this->getPath('packages').'/'.$package.'/info.xml';
		$result=array();
		if(file_exists($path)){	
			$data=simplexml_load_file($path);
			if(isset($data->dependencies->$part))
			{
				for($i=0;$i<count($data->dependencies->$part->item);$i++){
					$result[]=(String)$data->dependencies->$part->item[$i]['name'];
				}
			}
		}
		return $result;
	}
	/**
	 * Proceed internal libraries loading
	 *
	 * @return unknown
	 */
	public function loadLibs(){
		foreach($this->to_include as $k=>$v){
			if(!$this->registeredPackage($v))
			{
				$this->checkExtending($v);
				$this->includeLibs($v);
				$this->includeErrors($v);
				$this->includeAbstractions($v);
				$this->includeInterfaces($v);
				$this->includePackage($v);
			}
			#print $v;
		}
		return true;
	}
	
	public function loadOneLib($lib)
	{
		$this->checkExtending($lib);
		$this->includeLibs($lib);
		$this->includeErrors($lib);
		$this->includeAbstractions($lib);
		$this->includeInterfaces($lib);
		$this->includePackage($lib);	
	}
	
	
	/**
	 * Get random string user-defined length
	 *
	 * @param unknown_type $length
	 * @return unknown
	 */
	public function makeRandString($length)
	{
		$letters=array('a','b','c','d','e','f','g','h','i','j','k','l',
						'm','n','o','p','q','r','s','t','u','v','w','x',
						'y','z',0,1,2,3,4,5,6,7,8,9);
		$str='';
		for($i=0;$i<$length;$i++)
		{
			$str.=$letters[mt_rand(mt_rand(0,count($letters)-1),(count($letters)-1))];
		}	
		#die($str);
		return $str;
	}
	
	
	public function initedPackages()
	{
		return $this->instances;
	}
	/**
	 * Get one of module settings from database
	 *
	 * @param String $module
	 * @param String $param
	 * @return String
	 */
	public function getConfigParam($module,$param)
	{
		$data=$this->instances['database']->getSQLParameter('config','settings',array('module'=>$module));
		if(trim($data)!=''){
			$data=unserialize($data);
			return $data[$param];
		}else{
			return '';
		}
	}
	
	
	/**
	 * Decode system error message
	 *
	 * @param Integer $code
	 * @return string
	 */
	public function getErrorText($code){
				 $err_s=get_defined_constants("user");
				 foreach($err_s as $k=>$v){
					 if($v==$code){
						 $result=$k;
					 }
				 }
				 if(empty($result)){
					return false;
				 }
	}
}
?>