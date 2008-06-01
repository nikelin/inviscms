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
class errors implements errorsI{
	private $_data='';
	private $_handlingStarted=0;
	private $_error=0;
	private $_htmlShowMode='all';
	private $_htmlDebugLevel='debug';
	private $_htmlErrors=array();
	function __construct()
	{
		#print_r($this);
		$this->_data='<script type="text/javascript"><!--'."\n\r\n\r";
		$this->start();
		return true;
	}
	
	function started(){
		return($this->_handlingStarted);
	}
	
	function start(){
		$this->_handlingStarted=1;
	}
	
	function isError(){
		return $this->_error;
	}
 	function appendJSError($text){
		if(!$this->started()) return ERRORS_STREAM_NSET;
 		$this->_error=1;
		$this->_data.='alert("'.$text.'");'."\n\r";
 	}
 	function redirect($url){
		if(!$this->started()) return ERRORS_STREAM_NSET;
 		$this->_data.='window.location.href=\''.$url.'\';'."\n\r";
 	}
	function stopHandling()
	{
		$this->_data.="\r\n"."-->\r\n</script>\n\r";
	}
	
	public function htmlAppendError($data,$important="notice")
	{
		$this->_htmlErrors[]=array("text"=>$data,"important"=>$important);
	}
	
	public function htmlSetMode($mode="list")
	{
		$this->_htmlShowMode=$mode;	
	}
	
	public function htmlShow()
	{
		return $this->outputData("html");
	}
	
	public function htmlLastError()
	{
		return $this->renderHtmlError("last");
	}
	
	public function buflush()
	{
		$this->_htmlErrors=array();
	}
	public function htmlDebugLevel($level='notice'){
		$this->_htmlDebugLevel=$data;
	}
	
	public function renderHtmlError($mode="one",$id=null)
	{
		$result=null;
		switch($mode)
		{
			case 'one':
				$err=$this->_htmlErrors[is_numeric($id)?$id:(count($this->_htmlErrors)-1)];
				$bc='';
				switch($err['important'])
				{
					case 'notice':
						$bc="#00AA00";
						break;
					case 'warn':
						$bc="#0000EE";
						break;
					case 'fatal':
						$bc="#FF0000";
						break;
					default:
						$bc="#FF0000";
					break;
				}
				$result='<div style="border:2px '.$bc.' dotted;font-weight:bold;font-size:16px;">';
				$result.='<h3 style="text-align:center;margin:0;padding:0;color:#CC0000;">Ошибка!</h3>';
				$result.='<div style="text-align:center;">';
				$result.=$err['text'];
				$result.='</div>';
				$result.='<hr/>';
				$result.='<div style="text-align:center;">';
				$result.="<a style='font-size:17px;' href='/admin/support' title='Сообщить в службу поддержки'>Помощь</a>&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;";
				$result.="<a style='font-size:17px;' href='javascript:history.go(-1);'>Назад</a>";
				$result.="</div>";
				$result.='</div>';
				return $result;
			case 'last':
				$result=$this->renderHtmlError("one");
				break;
			case 'all':
				foreach($this->_htmlErrors as $k=>$v)
				{
					if($this->_htmlErrors[$k]['important']==$this->_htmlDebugLevel || $this->_htmlDebugLevel=='debug')
						$result.=$this->renderHtmlError("one",$k);
				}
				break;
			default: break;
		}
		return $result;
	}
	
	function outputData($mode="js")
	{
		switch($mode)
		{
			case 'html':
				if(count($this->_htmlErrors)>0)
				{
					return $this->renderHtmlError($this->_htmlShowMode);
				}
				break;
			case 'js':
			default:
				if(!$this->started()) return ERRORS_STREAM_NSET;
				$this->stopHandling();
				return $this->_data;
		}
	}
	
	public function internalError($package,$subject,$data,$type="warning")
	{
		if($q=$GLOBALS['database']->insertRow("errors",array("",$package,$subject,$data,$type,time(),serialize($_SERVER),serialize($_REQUEST))))
		{
			return 1;
		}else
		{
			return 0;
		}
	}
	
	public function getInternalErrors($render=true)
	{
		$result=null;
		$database=&$GLOBALS['database'];
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_errors`");
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				$data=array();
				while($data[]=$database->fetchQuery($q)){}
				$result=($render)?$this->renderInternalErrors($data):$result;
			}
		}
		return $result;;
	}
	
	private function renderInternalErrors($data)
	{
		$errors=new Errors();
		for($i=0;$i<count($data);$i++)
		{
			$errors->htmlAppendError($data[$i]['subject'],$data[$i]['type']);
		}	
		return $errors->outputData("html");
	}
}
?>
