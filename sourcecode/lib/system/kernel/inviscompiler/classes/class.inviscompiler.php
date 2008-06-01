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
class inviscompiler implements iinviscompiler{
	private $_paths=array();
	private $_errors=array(
		'warns'=>array(),
		'notices'=>array(),
		'criticals'=>array()
		);
	private $_input_data='';
	private $_output_data='';
	private $_lbracket='{\^';
	private $_rbracket='\^}';
	private $_included_tpls=array();
	private $_variables=array();
	private $_functions=array();
	private $_arrays=array();
	private $_tags=array();
	private $_patterns=array();
	private $_debug_mode=true;
	private $_damage_exitement=true;
	private $_output_to_file=false;
	private $_output_document='';
	private $_import_php_functions=true;
	private $_php_allowed=true;
	private $_functions_ignore_list=array();
	private $_inited=false;

	public function setPath($name,$value){
		$this->_paths[$name]=$value;
	}

	//Untrusted, need to check
	private function userDebugInformation($info=array()){
		$err_msg='';
		if(is_array($info)){
			if(isset($info[0]) && isset($info[1]) && isset($info[2]) && is_array($info[2])){
				$err_msg.='Инициирована в файле <strong>'.$info[2]['file'].'</strong>, строка №<strong>'.$info[2]['line'].'</strong> !<br />';
				$err_msg.='Уровень критичности: <span style="color:#FF0000;background-color:inherit;font-weight:bold;">'.$info[1].'</span><br />';
				$err_msg.='Текст ошибки:<br/>';
				$err_msg.='<em><strong>'.$info[0].'</strong></em><br/>';
				$err_msg.='$время инциализации: '.date("H:i:s d.m.Y",$info[2]['time']).'; IP-користувача: '.$info[2]['uip'].';<br /><br />';
				print $err_msg;
			}
		}
		return '';
	}

	//Need to check
	private function saveCache($tpl){
		//Save this template in the system cashe
		if(!$fp=fopen($this->_cache_path.'/INV_'.base64_encode($tpl).'.ht2','w+')){
			$this->setError('Помилка під час запису файлу історії !','notice',$this->getErrorInfo(__LINE__,__FILE__));
		}else{
			@flock($fp,LOCK_EX);
			$data='';
			$data.=md5($this->_output_data);
			$data.=gzcompress($this->_output_data);
			@fwrite($fp,$data);
			@flock($fp,LOCK_UN);
			@fclose($fp);
		}
	}

	//Need to check
	private function checkCache(){
		//Check for system cashe of this document
		$this->temp['_casheBody']='';
		$this->temp['_hash']=md5($this->_output_data);
		$dir=@opendir($this->_cache_path);
		while(false!==($this->temp['_tmpl_file']=@readdir($dir))){
			if(!$fp=@fopen($this->_cache_path.'/'.$this->temp['_tmpl_file'],'r+')){
				continue;
			}else{
				@flock($fp,LOCK_EX);
				$this->temp['_hash41']=@fgets($fp,32);
				if($this->temp['_hash41']==$this->temp['_hash']){
					@fseek($fp,32);
					while(!feof($fp)) $this->temp['_cacheBody'].=fread($fp,2048);
					break;
				}else{
					continue;
				}
				@flock($fp,LOCK_EX);
			}
		}
		return gzuncompress($this->_temp['_cacheBody']);
	}

	//Ok
	private function getErrorInfo($line,$file){
		$temp=array();
		$temp['time']=time();
		$temp['uip']=$_SERVER['REMOTE_ADDR'];
		$temp['line']=$line;
		$temp['file']=$file;
		return $temp;
	}

	
	public function Render($data,$type)
	{
		$this->_input_data=($type=="plain")?$data:$this->get_data($data);
		$this->initializeCompile();
		return $this->process();
	}
	
	private function process()
	{
		if($this->_inited){
			$this->_extractVariablesCalls();
			return $this->_input_data;
		}
	}
	
	public function newVariable($name,$value)
	{
		$this->_variables[$name]=$value;
	}

	public function _variable_exists($var){
		return (isset($this->_variables[$var]));
	}

	function initializeCompile(){
		$this->initializePatterns();
		$this->_inited=true;
		#$dat=$this->_input_data;
		#$this->_replaceIncludableTags();
		#if($this->_php_allowed) $this->_check_php_pastes();
		#die(md5($this->_input_data)==md5($dat));
	}

	function initializePatterns(){
		$this->_patterns['var']='/'.$this->_lbracket.'([a-zA-Z0-9_]{1,})'.$this->_rbracket.'/';
		$this->_patterns['included_tpl']='/'.$this->_lbracket.'include\(([а-яА-Яa-zA-Z0-9_\.\-]{1,})\)'.$this->_rbracket.'/';
		$this->_patterns['function_call']='/'.$this->_lbracket.'([a-zA-Z0-9_]{1,})\(([a-zA-Z0-9_\%]\,)*\)'.$this->_rbracket.'/';
	}

	public function setError($text,$level,$info=array()){
		if(isset($level) && trim($level)!=''){
			$this->_errors[$level][]=array($text,$info['time'],$info['line'],$info['file'],$info['uip']);
			if($this->_debug_mode){
				return $this->userDebugInformation(array($text,$level,$info));
			}
			if($this->_logofication_mode){
				$this->writeLogInfo(array($text,$level,$info));
			}
			if($level=='critical' && $this->_damage_exitement){
				die('System was crashed !');
			}
		}
		return '';
	}

	//Need to check
	function compileIncludable($data){
		$this->temp['_curr_tpl_restr']=$this->_input_data;
		$this->temp['getRSTTPL2']=$this->Render($data);
		$this->_input_data=$this->temp['_curr_tpl_restr'];
		return $this->temp['getRSTTPL2'];
	}

	function _extractVariablesCalls(){
		if(trim($this->_input_data)!=''){
			if(preg_match_all($this->_patterns['var'],$this->_input_data,$_sets)){
				foreach($_sets[1] as $k=>$v){
					#die_r($_sets);
					if($this->_variable_exists($v)){
						#print($this->_input_data);
						#die();
						$this->_input_data=str_replace(stripslashes($this->_lbracket).$v.stripslashes($this->_rbracket),$this->_variables[$v],$this->_input_data);
						#die($this->_input_data);
					}else{
						$this->setError('Змінна `'.$v.'` не зареестрована в системі !','critical',$this->getErrorInfo(__LINE__,__FILE__));
					}
				}
			}
		}else{
			$this->setError('Інформація для обробки не знайдена !','critical',$this->getErrorInfo(__LINE__,__FILE__));
		}
	}

	function setCacheDir($tpl){

	}

	function get_data($path){
		$result=null;
		if(!isset($path) || trim($path)==''){
			$this->setError('Kernel panic: Cannot locate template name !','critical',$this->getErrorInfo(__LINE__,__FILE__));
			$result='Error!';
		}else{
			ob_start();
			if(false===($result=($this->_php_allowed)?eval('?>'.join('',file($this->_paths['tmpls'].$path))):join('',file($this->_paths['tmpls'].$path)))){
				$this->setError('Неможливо завантажити текст шаблону '.$path,'warn',$this->getErrorInfo(__LINE__,__FILE__));
				$result='Error!';
			}
			$result=ob_get_contents();
			ob_end_clean();
		}
		#die($tpl.'<br/>'.$this->temp['_2']);
		return $result;
	}

	function _extractArraysCalls(){}

	function _extractFunctionCalls(){}

	function _replaceIncludableTags(){
		if(isset($this->_patterns['included_tpl'])){
			if(trim($this->_input_data)!=''){
				preg_match_all($this->_patterns['included_tpl'],$this->_input_data,$_sets);
				foreach($_sets[1] as $k=>$v){
					#$replacement=$this->compileIncludable($this->getTpl($this->_included_tpls[$v]));
					// 					die($v.$this->_lbracket.'inc('.$v.')'.$this->_rbracket);
					$this->_input_data=str_replace($this->_lbracket.'inc('.$v.')'.$this->_rbracket,$this->get_data($this->_included_tpls[$v]),$this->_input_data);
					#die($this->_input_data);
				}
			}
		}
	}
	function _checkLoops(){}
	function _checkIfStatements(){}
}
?>