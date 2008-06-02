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
class modules extends system
{
	/**
	 * Load user-module
	 *
	 * @param String(admin|client)+ $part
	 * @param String $module
	 * @param String $page
	 * @return string
	 */
	public function loadModule($part,$module,$page)
	{
		foreach($GLOBALS as $k=>$v){
				$$k=$v;
		}
		$result='';
		if($part!='client') $result=$this->buildNavTabs($module);
		if(isset($_POST['action_'.$page])){
			if($this->proceedAction($part,$module,$page)!=false){
				$result.=eval($this->proceedAction($part,$module,$page));
				$this->loadings['mAction_loaded']=true;
			}else{
				$result='';
				$errors->appendJSError('Error while proceeding action !');
				$this->loadings['mAction_loaded']=false;
			}
		}
		$form=eval('?>'.$this->putForm($part,$module,$page));
		if($form===false){
			$errors->appendJSError('Form including error !');
			$result='';
			$this->loadings['mForm_loaded']=false;
		}else{
			$result.=$form;
			$this->loadings['mForm_loaded']=true;
		}
		if($part=='admin')$result=$result;
		return $result;
	}
	
	private function buildNavTabs($module)
	{
		$res='<div class="navbar" style="background-color:#AAAAAA;color:inherit;display:block;text-align:center;">';
		$mod=getcwd().'/lib/modules/admin/'.$module.'/info.xml';
		if(file_exists($mod)){
			$xml=simplexml_load_string(join('',file($mod)));
			for($i=0;$i<count($xml->actions->action);$i++)
			{
               	$ob=$xml->actions->action[$i];
				$res.='<button onclick="Invis.core.loadPage(\''.$module.'\',\''.$ob['id'].'\');return false;" style="width:20%;">';
				$res.=$ob;
				$res.='</button>';
			}
		}
		$res.='</div>';
		return $res;
	}
	
	/**
	 * Wrapper to check that user proceed some actions
	 *
	 * @param String(admin|client)+ $part
	 * @param String $module
	 * @param String $act
	 * @return string
	 */
	private function proceedaction($part,$module,$act){
		$errors=$GLOBALS['errors'];
		$inc_path=getcwd().'/lib/modules/'.$part.'/'.$module.'/actions/'.$act.'.inc';
		if(!@file_exists($inc_path)){
			$errors->appendJSError('Ошибка во время проводки формы на сервере !');
			$data='';
			$this->loadings['mAction_loaded']=false;
		}else{
			$data=join(' ',@file($inc_path));
		}
		return ((trim($data)=='')?'?>'.('<span style="color:#FF0000;font-weight:bold;font-size:15px;">Ошибка во время проводки формы на сервере!</span>'):'?>'.$data);
	}
	
	/**
	 * Include javascript engine of the user-module
	 *
	 * @param unknown_type $part
	 * @param unknown_type $module
	 * @return unknown
	 */
	private function putjs($part,$module)
	{
		$js_path=getcwd().'/lib/modules/'.$part.'/'.$module.'/pieces/js.inc';
		if(file_exists($js_path)){
			$result="?>".join('',file($js_path));
		}else{
			$result=false;
		}
		return $result;
	}
	/**
	 * Include visual interface of one of the parts of user-module
	 *
	 * @param unknown_type $part
	 * @param unknown_type $module
	 * @param unknown_type $name
	 * @return unknown
	 */
	private function putform($part,$module,$name){
		$form_path=getcwd().'/lib/modules/'.$part.'/'.$module.'/forms/'.$name.'.frm';
		if(!file_exists($form_path)){
			$data=false;
		}else{
			$data=join(' ',file($form_path));
		}
		return ((trim($data)=='')?'Module declaration not found !':$data);
	}
	
		private function composePieces($part,$module){
		$mod_path=getcwd().'/lib/modules/'.$part.'/'.$module.'/pieces';
		$result=null;
		if(!file_exists($mod_path)){
			$result=false;
		}else{
			if(@file_exists($mod_path.'/sets.inc')){
				$result.=join('',@file($mod_path.'/sets.inc'));
			}
		}
		return ((trim($result)=='')?' ':$result);
	}
	
	public function modExists($part,$mod,$piece)
	{
		#die_r($this->getPath('modules').'/'.$part.'/'.$mod.'/forms/'.$piece.'.frm');
		return file_exists($this->getPath('modules').'/'.$part.'/'.$mod.'/forms/'.$piece.'.frm');
	}
	
	public function deniedModule($part,$module)
	{
		return (file_exists($this->getPath('modules').'/'.$part.'/'.$module.'/block.d'));
	}
	
	public function denyModule($part,$module)
	{
		return $GLOBALS['dirs']->mkfile($this->getPath('modules').'/'.$part.'/'.$modules.'/block.d');
	}
	
	public function isAllowed()
	{
		
	}
	
	public function check_modules_index()
	{
		
	}
	
	public function proceed(){
		ob_start();
		if(!file_exists($mod_path)){
			print $GLOBALS['uinterface']->buildClientPage($params['mod']);
		
		}else{	
			if(!$GLOBALS['modules']->deniedModule("client",$params['mod']))
			{
				print $GLOBALS['modules']->loadModule("client",rawurlencode($params['mod']),"main");
			}else{
				print "Модуль заблокирован !";
			}
		}
		$content=ob_get_contents();
		ob_end_clean();
		return $GLOBALS['tools']->applyWrappers($params['mod'],$content);
	}
}
?>