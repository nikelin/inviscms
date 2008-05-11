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
?><?
/**
* Class: csc (Cross Server Communication Library)
**/
class csc{

	var $_conn_id=null;
	var $_space=" ";
	var $_crlf="\n";
	var $_host='';
	var $_cleanURLs=false;
	var $_port=80;
	var $_protocol='';
	var $_contentType='text/html';
	var $_timeout=30;
	var $_err_str='';
	var $_err_no=0;
	var $_answer='';
	var $_errors_codes=array(21,205,51,86,31,11,7);
	var $_status=200;
	var $_server_info='';
	var $_request='';
	var $_protocols=array("http"=>"HTTP/1.1","ssl"=>"SSL/1.1");
	
	function setPort($port){
		if(is_numeric($port)){
			$this->_port=$port;
		}
	}

	function openConnection($host,$protocol='http',$port=80){
		$this->_host=$host;
		$this->_protocol=(preg_match("/[\/]+/",$protocol))?$protocol:$this->_protocols[$protocol];
		$this->_conn_id=fsockopen($this->_host,$port,$this->_err_no,$this->_err_str,$this->_timeout);
		if(!$this->_conn_id){
			return 0;
		}
		return 1;
	}

	function correctMethod($method){
		switch($method){
			case 'POST':
			case 'HEAD':
			case 'GET':
			case 'PUT':
			case 'TRACE':
				return true;
			default:
				return false;
		}
	}

	function sendQuery($method,$uri_s,$body='',$content_type="text/html"){
		if($this->_conn_id){
			if(trim($method)!='' && trim($uri_s)!=''){
				if($this->_cleanURLs){
					$uri=explode('&',$uri_s);
					if(count($uri)>1){
						$i=0;
						foreach($uri as $k=>$v){
							$v=explode('=',$v);
							if(count($v)>1){
								$v=$v[0].'='.rawurlencode($v[1]);
								$uri_s.=$v;
								$uri_s.=($i<(count($uri)-1))?'&':'';
								$i++;
							}
						}
					}else{
						$uri='/'.$uri_s;
					}
				}
				$this->_request='';
				if($this->correctMethod($method)){
					$this->_request.=$method.$this->_space;
					$this->_request.=$uri_s.$this->_space;
					$this->_request.=$this->_protocol.$this->_crlf;
					$this->_request.='Host: '.$this->_host.$this->_crlf;
					$this->_request.='Referer: http://'.$_SERVER['HTTP_HOST'].'/hello.html'.$this->_crlf;
					$this->_request.='Content-Type: '.$content_type.';'.$this->_crlf;
					if($method=='POST'){
						$this->_request.='Content-Length: '.strlen($body).$this->_crlf.$this->_crlf;
						$this->_request.=$body.$this->_crlf;
					}
					$this->_request.='Connection: Close'.$this->_crlf.$this->_crlf;
					#die($this->_request);
					$this->_answer=fwrite($this->_conn_id,$this->_request,strlen($this->_request));
					if(!$this->_answer){
						return 0;
					}else{
						return 1;
					}
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}

	function isError($code){
		return(in_array($code,$this->_errors_codes)?true:false);
	}

	function readAnswer($xml=true,$cut_headers=false){
		$result='';
		if($this->_conn_id){
			if($this->_answer){
				while(!feof($this->_conn_id)){
					$result.=fread($this->_conn_id,1024);
					#$this->_result.=($this->_conn_id);
				}
				#die_r($result);
				if($cut_headers){
					$result=ltrim(substr($result,strpos($result,"\n\r")));
				}else{
					$result=array('body'=>substr($result,strpos($result,"\n\r")),'headers'=>substr($result,0,strpos($result,"\n\r")));
				}
			}else{
				$result=0;
			}
		}else{
			$result=0;
		}
		if($xml){
			$result=substr($this->_result,strpos($result,'<'));
		}
		return $result;
	}

	function closeConnection(){
		if(fclose($this->_conn_id)){
			$this->_conn_id=null;
			return false;
		}else{
			return false;
		}
	}

	function getInfo(){
	}

	function getErrorInfo(){
	}
}
?>