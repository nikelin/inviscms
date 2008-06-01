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
// Controller of payment system
class paymentcontroller
{
	private $_path='./lib/core/paysys';
	private $_toload=array();
	private $_active=array();
	private $_instances=array();
	private $_configs=array();
	
	public function loadSystem($id)
	{
		$syspath=$_path.'/'.$id.'/config.xml';
		if(file_exists($syspath))
		{
			if(!in_array($id,$this->_active))
			{
				if(false!==($data=@simplexml_load_file($syspath)))
				{
					if($this->validNFOFile($data))
					{
						if(class_exists($data->config->driver['value']))
						{
							$this->_instances[$data->config->driver['value']]=new $data->config->driver['value']();
						}
					}
				}
			}			
		}
	}
	
	public function getPath(){
		return $this->_path;
	}
	
	public function unloadSystem($id)
	{
		
	}
	
	
	public function autoLoad(){}
	
	public function getActiveSystems()
	{
		$result=false;
		$d=opendir($this->getPath());
		while(false!==($s=readdir($d)))
		{
			if($s!='.' && $s!='..')
			{
				$config=$this->getPath().'/'.$s.'/config.xml';
				if(file_exists($config))
				{
					$data=simplexml_load_file($config);
					if($data)
					{
						if($data->status['value']=='on'){
							#print_rbr($s);
							$result[]=array('title'=>(String)$data->config->label,'id'=>$data->config->driver[0]['name']);
						}
					}
				}
			}
		}
		return $result;
	}
	
	public function getInterfaces($sys)
	{
		$result=array();
		$path=$this->getPath().'/'.$sys.'/config.xml';
		if(file_exists($path))
		{
			$config=@simplexml_load_file($path);
			if($config)
			{
				for($i=0;$i<count($config->interfaces->item);$i++)
				{
					$result[]=array(
						'id'=>(String)$config->interfaces->item[$i]['value'],
						'title'=>(String)$config->interfaces->item[$i]['label']
						);
				}
			}
		}
		return $result;
	}
	
	public function getAuthInfo($sys)
	{
		$result=array();
		$database=&$GLOBALS['database'];
		$system=&$GLOBALS['system'];
		$path=$this->getPath().'/'.$sys.'/auth.xml';
		if(file_exists($path))
		{
			$data=@simplexml_load_file($path);
			if($data)
			{
				if(@$data->crypted['value']=='yes')
				{
					$q=$database->getRows("settings","paykey");
					if(!$database->isError($q) && $database->getNumrows($q)!=0)
					{
						$key=$database->fetchQuery($q);
						$decxml=@simplexml_load_string($system->decdata($data->auth,$key['paykey']));
						if($decxml && @$decxml->item[0] && @$decxml->item[1]){
							$result['login']=(String)@$decxml->item[0]['value'];
							$result['passwd']=(String)@$decxml->item[1]['passwd'];
							if(count($data->auth->item)>2)
							{
								$ob=&$data->auth->item;
								for($i=0;$i<count($ob);$i++)
								{
									$result[$ob[$i]['name']]=$ob[$i]['value'];
								}
							}
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					$result['login']=(String)$data->auth->item[0]['value'];
					$result['passwd']=(String)$data->auth->item[1]['value'];
					if(count($data->auth->item)>2)
					{
						$ob=&$data->auth->item;
						for($i=0;$i<count($ob);$i++)
						{
							$result[(String)$ob[$i]['name']]=(String)$ob[$i]['value'];
						}
					}
				}
			}
		}
		return $result;
	}
	
	public function changeAuthInfo($sys,$data,$crypt=false)
	{
		$database=&$GLOBALS['database'];
		$system=&$GLOBALS['system'];
		$result=false;
		if(trim($sys)!='' && is_array($data) && in_array('login',$data) && in_array('passwd',$data))
		{
			if($this->sysExists($sys))
			{
				$path=$this->getPath().'/'.$sys.'/auth.xml';
				if(is_writable($path))
				{
					$to_write='<?xml version="1.0"?>';
					$to_write.='<data>';
					$to_write.='<system>'.$sys.'</system>';
					$to_write.='<crypted value="'.($crypted)?'yes':'no'.'"/>';
					$to_write.='<auth>';
					$auth='<login>'.$data['login'].'</login>';
					$auth.='<passwd>'.$data['paswd'].'</passwd>';
					if(count($data)>2){
						foreach($data as $k=>$v){
							if($k!='login' && $k!='passwd')
							{
								$auth.='<'.$k.'>'.$v.'</'.$k.'>';
							}
						}
					}
					if($crypted){
						$q=$database->getRows("settings","paykey");
						if(!$database->isError())
						{
							$data=$database->fetchQuery($q);
							if(@$data['paykey'])
							{
								$auth=$system->encdata($auth,$data['paykey']);
							}else{
								return false;
							}
						}else{
							return false;
						}
					}
					$to_write.=$auth;
					$to_write.='</auth>';
					$to_write.='</data>';
					if(false!==($fp=@fopen($path,'w+')))
					{
						@flock($fp,LOCK_EX);
						if(@fwrite($fp,$to_write))
						{
							$result=true;
						}
						@flock($fp,LOCK_UN);
						@fclose($fp);
					}
				}
			}
		}
		return $result;
	}
	
	public function loadInterfaceUI($sys,$part,$interface)
	{
		return eval('?>'.join('',file($this->getPath().'/'.$sys.'/interfaces/'.$part.'/'.$interface.'/main.frm')));
	}
	
	public function setPath($path)
	{
		if(trim($path)!='' && file_exists($path))
		{
			$this->_path=$path;
		}
	}
	
	public function getSystemInfo($id)
	{
		
	}
	
	public function configure($data){}
	
	public function getConfigInfo($system){}
}
?>