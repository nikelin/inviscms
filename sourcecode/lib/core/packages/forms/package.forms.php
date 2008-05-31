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
class forms implements iforms
{
	private $_inited=false;
	private $_form=array();
	private $_elems=array();
	private $_fields=array();
	private $_patterns=array();
	private $_others='';
	private $_js=array();
	private $_data='';
	private $css=array();

	/**
	 * Setter for CSS-fields
	 *
	 * @param String $key
	 * @param String $value
	 */
	public function setCSSValue($key,$value)
	{
		$this->css[$key]=$value;
	}
	
	/**
	     * Make new instance of the form container.
	     * @return Void
	     * @param $method String
	     * @param $action String
	     * @param $encoding String
	     * @param $params Array[optional]
	     */
	public function init($method,$action,$encoding='',$name='',$id='',$params=array())
	{
		$id=(!$id)?'f_'.md5(time().$name.$action).'_'.mt_rand(10,99):$id;
		if($this->correctMethod($method) && !$this->_inited){
			$this->_data='';
			$this->_form['method']=$method;
			$this->_form['action']=$action;
			$this->_form['encoding']=$encoding;
			$this->_form['params']=$params;
			$this->_form['id']=$id;
			$this->_form['name']=$name;
			$this->initOthers();
			$this->_inited=true;
		}else{
			return IFORM_WRONG_METHOD;
		}
	}

	/**
		 * Add the hidden field to the current form
		 * @return Void
		 * @param $name Object
		 * @param $value Object
		 * @param $id Object[optional]
		 */    
	public function addHidden($name,$value,$id='')
	{
		$id=(!$id)?'h_'.md5(time().$name.$value).'_'.mt_rand(10,99):$id;
		$this->_others.='<input type="hidden" name="'.$name.'" value="'.$value.'" id="'.$id.'"/>';
	}

	/**
	 * Initializing of primery data
	 *
	 */
	protected function initOthers(){
		//CSS
		$this->css['singleFieldLabelClass']='label label1 center';
		$this->css['sinleFieldLabelStyle']='width:100%;clear:both;display:block;';

		$this->css['formLegendClass']='legend';

		$this->css['pairFieldValueClass']='value value1';
		$this->css['pairFieldValueStyle']='';
		$this->css['pairFieldLabelClass']='label label1';
		$this->css['pairFieldLabelStyle']='';
		$this->css['singleFieldValueClass']="value center";
		$this->css['singleFieldValueStyle']="width:100%;clear:both;";
		$this->css['rowClass']='row';
		$this->css['formMainClass']='form';
		$this->css['formMainStyle']='';
		$this->css['submitClass']='label submit center';

		//JS
		$this->js['validateFunct']='Invis.tools.checkValue(this.id);';
	}

	/**
		 * Add the legend text to the current form
		 * @return 
		 * @param $text Object
		 */
	public function addLegend($text){
		$this->_form['legend']=$text;
	}

	/**
		 * Check that $method is the valid HTTP method
		 * @return Boolean
		 * @param $method Object
		 */
	protected function correctMethod($method)
	{
		switch($method){
			case 'GET':
			case 'POST':
			case 'PUT':
				return true;
		}
		return false;
	}

	/**
		 * Append eventHandler to added to form input element
		 * @return integer
		 * @param $name String 
		 * @param $event String
		 * @param $handler String
		 */
	public function addEventHandler($name,$event,$handler){
		if(trim($name)!='' && trim($event)!='' && trim($handler)!=''){
			for($i=0;$i<count($this->_elems);$i++){
				if($this->_elems['name']==$name){
					$this->_elems[$i]['on'][]=array($event=>$handler);
					break;
				}
			}
		}else{
			return IFORM_WRONG_PARAMS;
		}
		return 1;
	}

	/**
		 * Add submit control to the form
		 * @return void
		 * @param $name Object
		 * @param $value Object
		 * @param $style Object[optional]
		 */
	public function addSubmit($name,$value,$params=array())
	{
		if(trim($name)!=''){
			$this->_submit[]=array('name'=>$name,'value'=>$value,'params'=>$this->_prepareParams($params));
		}
	}

	/**
		 * Check that element with value of type $type equals $value
		 * @return integer
		 * @param $type String
		 * @param $value String
		 */
	protected function elemExists($type,$value)
	{
		for($i=0;$i<count($this->_elems);$i++){
			switch($type)
			{
				case 'name':
					if($this->_elems[$i]['name']==$value)return 1;
					break;
				case 'id':
					if($this->_elems[$i]['id']==$value)return 1;
					break;
			}
		}
		return 0;
	}

	/**
		 * Set "important" parameter to the $id - input element
		 * @return integer
		 * @param $name String
		 */
	public function validateElement($id)
	{
		if(trim($name)==''){
			return IFORM_WRONG_PARAMS;
		}else{
			if(!$this->elemExists("id",$id)){
				return IFORM_WRONG_ELEM;
			}else{
				//FIX ERROR
				$this->_elems[array_search($name,$this->_elems)]['validate']=true;
			}
		}
		return 1;
	}

	/**
		 * Add input element to the current form
		 * @return String 
		 * @param $type String
		 * @param $name String
		 * @param $parent String
		 * @param $id String[optional]
		 * @param $value String[optional]
		 * @param $validate Boolean[optional]
		 * @param $params String[optional]
		 */
	public function addInput($type,$name,$parent,$id='',$params='',$value='',$validate=false)
	{
		#  if($type=='textarea')die_r(func_get_args());
		if(trim($type)!='' && trim($name)!='' && trim($parent)!=''){
			$id=(!$id)?'i'.md5($name).'_'.count($this->_elems):$id;
			$this->_elems[]=array(
			'id'=>$id,
			'type'=>$type,
			'parent'=>$parent,
			'name'=>$name,
			'value'=>$value,
			'validate'=>$validate,
			'on'=>array(),
			'params'=>$params
			);
		}else{
			return IFROM_WRONG_PARAMS;
		}
		return $id;
	}

	/**
		 * Add field to the form
		 * @return String 
		 * @param $label String
		 * @param $type String[optional]
		 * @param $el String[optional]
		 * @param $id String[optional]
		 * @param $params String[optional]
		 */
	public function addField($label,$type="pair",$value="",$params="",$id='')
	{
		$id=(!$id)?'f'.md5($label).'_'.count($this->_fields):$id;
		$this->_fields[]=array("id"=>$id,"label"=>$label,"type"=>$type,"value"=>$value,"params"=>$params);
		return $id;
	}

	/**
		 * Initialize system patterns
		 * @return void 
		 */
	protected function initPatterns()
	{
		$this->_patterns['form']='<form action="%s" method="%s" enctype="%s" %s>';
		$this->_patterns['inputI']='<input type="%s" name="%s" value="%s" id="%s" %s %s %s/>';
		$this->_patterns['inputD']='<div class="%s"><span class="%s" style="%s"><%s name="%s" id="%s" %s %s %s>%s</%s></span></div>';
		$this->_patterns['inputC']='<%s name="%s" id="%s" %s %s %s>%s</%s>';
		$this->_patterns['fieldsingle']='<div class="%s" style="%s" id="%s" %s>%s</div>%s';
		$this->_patterns['fieldpair']='<div class="%s" %s id="%s"><span class="%s" style="%s">%s</span><span style="%s">%s</span></div>';
		$this->_patterns['formLegend']='<div class="'.$this->css['formLegendClass'].'">%s</div>';
		$this->_patterns['mainContainer']='<div class="'.$this->css['formMainClass'].'" style="'.$this->css['formMainStyle'].'">';
		$this->_patterns['endContainer']='</div></form>';
		$this->_patterns['submit']='<div class="row"><span class=" '.$this->css['submitClass'].'" style="clear:both;"><input type="submit" name="%s" value="%s" %s/></span></div>';
	}

	/**
		 * Transform $pairs-array to the <option> elements
		 * @return String
		 * @param $pairs Object
		 */
	protected function _prepareSelectOptions($pairs){
		$res=null;
		if(is_array($pairs) && count($pairs)>0)
		{
			foreach($pairs as $k=>$v){
				$res.="<option value='".$k."'>".$v."</option>";
			}
		}
		return $res;

	}

	/**
		 * Get inputs which referers to $parent-field
		 * @return String
		 * @param $parent Object
		 */
	protected function _getChildsInputs($parent){
		$res='';
		for($i=0;$i<count($this->_elems);$i++)
		{
			if($this->_elems[$i]['parent']==$parent){
				switch($this->_elems[$i]['type']){
					case 'textarea':
						# die_r($this->_elems[$i]['params']);
						$res.=sprintf(
						$this->_patterns['inputD'],
						$this->css['rowClass'],
						$this->css['singleFieldValueClass'],
						$this->css['singleFieldValueStyle'],
						$this->_elems[$i]['type'],
						$this->_elems[$i]['name'],
						$this->_elems[$i]['id'],
						($this->_elems[$i]['validate'])?'onclick="'.$this->js['validateFunct'].'"':'',
						$this->_getEvents($i),
						$this->_prepareParams($this->_elems[$i]['params']),
						$this->_elems[$i]['value'],
						$this->_elems[$i]['type']
						);
						break;
					case 'file':
					case 'password':
					case 'checkbox':
					case 'text':
						$res.=sprintf(
						$this->_patterns['inputI'],
						$this->_elems[$i]['type'],
						$this->_elems[$i]['name'],
						$this->_elems[$i]['value'],
						$this->_elems[$i]['id'],
						($this->_elems[$i]['validate'])?'onclick="'.$this->js['validateFunct'].'"':'',
						$this->_getEvents($i),
						$this->_prepareParams($this->_elems[$i]['params'])
						);
						break;
					case 'select':
						#die($this->_prepareSelectOptions($this->_elems[$i]['value']));
						$res.=sprintf(
						$this->_patterns['inputC'],
						$this->_elems[$i]['type'],
						$this->_elems[$i]['name'],
						$this->_elems[$i]['id'],
						($this->_elems[$i]['validate'])?'onclick="'.$this->js['validateFunct'].'"':'',
						$this->_getEvents($i),
						$this->_prepareParams($this->_elems[$i]['params']),
						$this->_prepareSelectOptions($this->_elems[$i]['value']),
						$this->_elems[$i]['type']
						);
						break;
					default:
						$res=IFORM_WRONG_TYPE;
				}
			}
		}
		return $res;
	}

	/**
		 * 
		 * @return String
		 * @param $elId Integer
		 */
	protected function _getEvents($elId){
		$result=null;
		if(array_search($elId,$this->_elems)!=-1){
			foreach($this->_elems[$elId]['on'] as $k=>$v)
			{
				$result.=' on'.$k.'="return '.$v.'();" ';
			}
		}else{
			$result=IFORM_NOT_EXISTS;
		}
		return $result;
	}

	/**
		 * Make the HTML attribute string which is based on $data-array
		 * @return 
		 * @param $data Object
		 */
	private function _prepareParams($data)
	{
		$res=null;
		if(is_array($data)){
			foreach($data as $k=>$v)
			{
				$res.=$k."=\"".$v."\"";
			}
		}
		#print_rbr($res);
		return $res;
	}

	/**
		 * Proceed rendering of the form object
		 * @return 
		 * @param $output Object[optional]
		 */
	public function render($output=true)
	{
		$this->initPatterns();
		$this->_data=sprintf($this->_patterns['form'],$this->_form['action'],$this->_form['method'],$this->_form['encoding'],$this->_prepareParams($this->_form['params']));
		$this->_data.=sprintf($this->_patterns['mainContainer']);
		$this->_data.=sprintf($this->_patterns['formLegend'],($this->_form['legend'])?$this->_form['legend']:'');
		$this->_data.='<input type="hidden" name="genericDATA" id="fX'.md5(time()).'" value="'.time().'"/>';
		for($i=0;$i<count($this->_fields);$i++)
		{
			switch($this->_fields[$i]['type'])
			{

				case 'pair':
					$this->_data.=sprintf(
					$this->_patterns['fieldpair'],
					$this->css['rowClass'],
					$this->_prepareParams($this->_fields[$i]['params']),
					$this->_fields[$i]['id'],
					$this->css['pairFieldLabelClass'],
					$this->css['pairFieldLabelStyle'],
					$this->_fields[$i]['label'],
					$this->css['pairFieldValueClass'],
					($this->_fields[$i]['value']=='')?$this->_getChildsInputs($this->_fields[$i]['id']):$this->_fields[$i]['value']
					);

					break;
				case 'single':
					$this->_data.=sprintf(
					$this->_patterns['fieldsingle'],
					$this->css['singleFieldLabelClass'],
					$this->css['sinleFieldLabelStyle'],
					$this->_fields[$i]['id'],
					$this->_prepareParams($this->_fields[$i]['params']),
					$this->_fields[$i]['label'],
					$this->_getChildsInputs($this->_fields[$i]['id'])
					);
					break;
			}
		}
		for($i=0;$i<count($this->_submit);$i++)
		{
			$this->_data.=sprintf($this->_patterns['submit'],$this->_submit[$i]['name'],$this->_submit[$i]['value'],$this->_submit[$i]['params']);
		}
		$this->_data.=$this->_others;
		$this->_data.=sprintf($this->_patterns['endContainer']);
		$this->_data=str_replace('{percent}','%',$this->_data);
		return ($output)?$this->_data:'';
	}

	/**
		 * Get rendered data
		 * @return String 
		 */
	function getData()
	{
		return $this->_data;
	}

}
?>
