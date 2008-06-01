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
class api
{
	/**
	 * Default variable environment
	 */
	private $_default_env="GET";
	/**
	 * Default API-server
	 */
	private $_default_module="constructor";
	/**
	 * Default response charset
	 */
	private $_charset="utf-8";
	/**
	 * Path to core-directory
	 */
	private $_sys_path='';
	/**
	 * Current session errors
	 */
	private $_errors=array();
	/**
	 * Engines list
	 */
	private $engines=array();

	/**
	 * Contructor
	 * When calling set default core-directory path
	 * @return 
	 */
	public function __construct()
	{
		$this->_sys_path=$GLOBALS['path_to_site'].'/lib/core/api';
	}
	
	/**
	 * Proceed API-servers initialization (* ALIAS of $this->serversInit())
	 * @return 
	 */
	public function init()
	{
		$this->serversInit();
	}

	/**
	 * Set core-directory
	 * @return 
	 * @param $path Object
	 */
	public function setPath($path)
	{
		$this->_sys_path=$path;
	}

	/**
	 * Get path to the core-directory
	 * @return 
	 */
	private function getPath()
	{
		return $this->_sys_path;
	}
	
	
	/**
	 * Check that this API-server exists, and content configuration data
	 * @return 
	 * @param $api Object
	 */
	protected function _checkExists($api)
	{
		return (file_exists($this->getPath().'/'.$api.'/config.xml') && file_exists($this->getPath().'/'.$api.'/init.php'));
	}

	public function isError($code){
		return (in_array($code,$this->_errs));
	}
	
	public function _authority_proceed($data)
	{
		
	}


	/**
	 * Register current API-server and all linked protocols
	 * @return boolean 
	 * @param $api Object
	 * @param $data Object
	 */
	public function registerEngine($api,$data)
	{
		$result=false;
		$ts=array();
		if($data->item && $api!='')
		{
			$ts=array();
				$ts[$api]=array();
				for($i=0;$i<count($data->item);$i++)
				{
					$ob=$data->item[$i];
					$identifier=(String)$ob->identifier;
					$ts[$api][$identifier]=array();
					$ts[$api][$identifier]['keys']=array();
					$ts[$api][$identifier]['access']=(String)$ob['access'];
					if($ob->environment && count($ob->environment->item)>=0)
					{
						$ts[$api][$identifier]['environment']=array();
						for($j=0;$j<count($ob->environment->item);$j++)
						{
							$ts[$api][$identifier]['environment'][]=(String)$ob->environment->item[$j]['value'];
						}
						if($identifier && trim($identifier)!=''){
							if(isset($ob->params))
							{
								if(isset($ob->params->item) && count($ob->params->item)>=0){
									for($j=0;$j<count($ob->params->item);$j++)
									{
										$ob_p=$ob->params->item[$j];
										if(!isset($ob_p["name"]) || !isset($ob_p["type"])){
											$this->setError("Not inited:".$api.";wrong protocol declaration");
											return API_INVALIDE_PROTOCOL;
										}else{
											$ts[$api][$identifier]['keys'][]=array('name'=>(String)$ob_p['name'],'type'=>(String)$ob_p['type'],"important"=>(isset($ob_p->important))?(bool)$ob_p->important:0);
										}
									}
								}
							}else{
								$this->setError("Not inited:".$api.";wrong protocol declaration");
								return API_INVALIDE_PROTOCOL;
							}
						}else{
							$this->setError("Not inited:".$api.";wrong protocol declaration");
							return API_INVALIDE_PROTOCOL;
						}
					}else{
						$this->setError("Not inited:".$api.";wrong protocol declaration");
						return API_INVALIDE_PROTOCOL;
					}
				}
			}else
			{
				$this->setError("Not inited:".$api.";wrong protocol declaration");
				return API_WRONG_PARAMS;
			}
		$this->engines=$ts;
		return $result;
	}

	/**
	 * Init all API-servers, what stored in $this->getPath() directory
	 * @return Void
	 */
	public function serversInit()
	{
		$api_root=$this->getPath();
		$p=opendir($api_root);
		while(false!==($d=readdir($p)))
		{
			if($d!='.' && $d!='..' && is_dir($api_root.'/'.$d))
			{
				if(file_exists($api_root.'/'.$d.'/init.php') && file_exists($api_root.'/'.$d.'/config.xml'))
				{
					$settings=@simplexml_load_file($api_root.'/'.$d.'/config.xml');
					if(!$settings){
						$this->setError('Not inited: '.$d.'; wrong config file.');
						continue;
					}else{
						#die_r($settings->api->name);
						$this->registerEngine((String)$settings->api->name,$settings->api->protocols);
					}
				}
			}
		}
	}


	/**
	 * Validate params
	 * @return 
	 * @param $api Object
	 * @param $params_list Object
	 */
	public function _validate_params($api,$params_list)
	{
		foreach($params_list as $k=>$v)
		{
			if(!(($k!='p' &&
			(@array_key_exists($k,$this->_api[$api]['params']['keys']
			&&
			$this->_api[$api_id]['keys'][$k]['important']
			&& gettype($v)==$this->_api[$api_id]['params']['keys'][$k]['type'])))))
			return false;
		}
		return true;
	}



	/**
	 * Method to proceed client authorization in case of InnoAuthProtocol ({core}/packages/inno_auth_protocol)
	 * @return 
	 * @param $url Object
	 * @param $sKey Object
	 */
	public function _authorizeClient($url,$sKey)
	{
		$iap=&$GLOBALS['inno_auth_protocol'];
		if(!$this->_authorizedClient())
		{
			$iap->helloSend();
		}
	}

	/**
	 * Check acces mode of the protocol 
	 * @return 
	 * @param $mod Object
	 * @param $protocol Object
	 */
	private function checkAccessMode($mod,$protocol)
	{
		//$this->isInternalRequest() || $this->_authorizedClient() || 
		return ($this->engines[$mod][$protocol]['access']=='all');
	}
	
	
	/**
	 * Check that api-interfaces $mod have registered protocol $protocol
	 * @return 
	 * @param $mod Object
	 * @param $protocol Object
	 */
	private function _registered($mod,$protocol)
	{
		$mod=(String)$mod;
		$protocol=(String)$protocol;
		if(array_key_exists($mod,$this->engines))
		{
			foreach($this->engines[$mod] as $k=>$v)
			{
				if($k==$protocol) return true;
			}
			return false;
		}else{
			return false;
		}
	}
	
	private function checkQSArguments($env,$mod,$protocol)
	{
		if(is_array($env))
		{
			for($i=0;$i<count($env);$i++)
			{
				if($this->checkQSArguments($env[$i],$mod,$protocol))
				{
					return $env[$i];
				}
			}
		}else{
			$data=$GLOBALS['tools']->getEnvVars($env,true);
			$ob=$this->engines[$mod]['protocol']['keys'];
			for($i=0;$i<count($ob);$i++)
			{
				if((!in_array($ob['name'],$data) && $ob['important']) || $ob['type']!=gettype($data[$ob['name']]))
				{
					return false;
				}
			}		
			return true;
		}
	}
	
	private function getProtocolArgsNames($args,$env)
	{
		$data=null;
		$envr=&$GLOBALS['tools']->getEnvVars($env,true);
		#die_r($envr);
		for($i=0;$i<count($args);$i++)
		{
			$data[$args[$i]['name']]=$envr[(String)$args[$i]['name']];
		}
		return $data;
	}
	
	
	/**
	 * Wrapper function, what check is there any request has been sends
	 * @return 
	 */
	public function waitForRequest()
	{
		$tools=&$GLOBALS['tools'];
		$result=null;
		$data=array("GET"=>$tools->getEnvVars("GET",true),"POST"=>$tools->getEnvVars("POST",true),"FILES"=>$tools->getEnvVars("FILES",false));
		$mod=(isset($data['module']))?$data['module']:$this->_default_module;
		if(false!==($protocol=(isset($data['GET']['protocol'])?$data['GET']['protocol']:(isset($data['POST']['protocol'])?$data['POST']['protocol']:$this->_default_protocol))) && is_numeric($protocol))
		{
			$env=($this->engines[$mod][$protocol]['environment'])?$this->engines[$mod][$protocol]['environment']:$this->_default_env;
			if($this->_registered($mod,$protocol))
			{
				if(false!==($env=$this->checkQSArguments($env,$mod,$protocol)))
				{
					$t=@include_once($this->getPath().'/'.$mod.'/init.php');
					if($t)
					{
						if($this->checkAccessMode($mod,$protocol))
						{
							$args=$this->getProtocolArgsNames($this->engines[$mod][$protocol]['keys'],$env);
							$result=$this->genResponse($this->callProtocol($mod,$protocol,$args),$this->registerQuery($mod,$protocol));
						}
					}else{
						$result=API_INVALIDE_PROTOCOL;
						$this->setError("Autostop inited; invalide protocol");
					}
				}
			}else{
				$result=API_INVALIDE_PROTOCOL;
			}
		}else{
			$this->setError("Autostop inited; undefined protocol was called");
			$result=API_INVALIDE_PROTOCOL;
		}
		return $result;
	}
	
	/**
	 * Call destination protocol
	 * @return 
	 * @param $mod Object
	 * @param $protocol Object
	 * @param $args Object
	 */
	private function callProtocol($mod,$protocol,$args)
	{
		$data=null;
		$file=$this->getPath().'/'.$mod.'/protocols/'.$protocol.'.php';
		if(@file_exists($file))
		{
			if(@include($file))
			{
				$data=protocol_main($args);
			}
		}
		return $data;
	}

	/**
	 * Register current transaction in database
	 * @return 
	 * @param $mod Object
	 * @param $interface Object
	 */
	private function registerQuery($mod,$interface)
	{
		$database=&$GLOBALS['database'];
		if(false!==($tid=$database->insertRow("clx_responses",array("",$mod,$interface,$_SERVER['REMOTE_ADDR'],time()))))
		{
			return $tid;
		}else{
			return -1;
		}
	}

	/**
	 * OLD FUNCTION, DO NOT USE !!!!
	 * @return 
	 * @param $data Object
	 */
	private function readXMLQuery($data)
	{
		$result=array();
		if(is_array($data))
		{
			if(false!==($data=@simplexml_load_string($data['body'])))
			{
				if($data->destinationProtocol){
					$result['protocol']=$data->destinationProtocol;
					foreach($data->userData as $k=>$v)
					{
						print_rbr($v);
					}
				}else{
					$result=API_QUERY_WRONG;
				}
			}else{
				$this->setError("Reading error: ".$data."; wrong xml-declaration;");
				$result=API_QUERY_ERROR;
			}
		}else{
			$this->setError("Reading error: ".$data."; wrong xml-declaration;");
			$result=API_WRONG_PARAMS;
		}
	}

	private function genResponse($data,$quid)
	{
		
		$result='<?xml version="1.0" standalone="true" encoding="'.$this->_charset.'"?>';
		$result.="<data id='".$quid."'>";
		$result.=$data;
		$result.="</data>";
		$result.="<!--GENERIC_REPORT:".$quid."-->";
		#die_r($result);
		return $result;
	}
	
	public function getCharset()
	{
		return $this->_charset;
	}

	private function setError($text)
	{
		$this->_errors[]=$text;
		$this->_last_error=$text;
	}
}
?>
