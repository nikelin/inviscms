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
class packages extends system
{
	private function validatePackage($pack)
	{
		$xml=new xml();
		$errors=new Errors();
		$xml->init($this->getPath('packages').'/'.$pack.'/info.xml');
		$bitsize=$xml->xpath_node("authority/bitsize");
		$parts=$xml->xpath_node("authority/includes/item");
		for($i=0;$i<count($parts);$i++)
		{
			$ob=$parts[$i];
			$path=($ob['type']!='libs')?$this->getPath((String)$ob['type']).'/'.$ob['name'].'/package.'.$ob['name'].'.php':$this->getPath('others').'/'.$ob['name'].'.php';
			if(!file_exists($path) || md5_file($path)!=$ob['md5'])
			{
				$errors->internalError('packages',"package structure error","Package: ".$pack);	
			}else
			{
				if($this->externalCheckAllowed())
				{
					if($this->externalCheckProceed("package"))
					{
						return true;
					}else
					{
						$errors->internalError("packages","error while attempt to set connection with authority center","Package: ".$pack);
					}
				}else
				{
					return true;
				}
			}
		}	
		return false;
	}
	
	private function externalCheckAllowed()
	{
		return $GLOBALS['database']->getSQLParameter("settings","external_authority_check",array(1=>1));
	}
	
	private function authorityServerHost()
	{
		return $GLOBALS['database']->getSQLParamter("settings","external_authority_host",array(1=>1));
	}
	
	private function externalCheckProceed($pack)
	{
		$csc=&$GLOBALS['csc'];
		$errors=new Error();
		$ap=new inno_auth_protocol();
		$csc=new csc();
		if($ap->hello_send($this->authorityServerHost(),"/client/auth"))
		{
			$trust_msg=$ap->proceed_authorize();
			if(trim($trust_msg)!='')
			{
				$key=$database->getSQLParameter("settings","rsp_key",array(1=>1));
				$trust_msg=$this->decr($trust_msg,$key);
				if($sid=$ap->authentificate($trust_msg))
				{
					if($csc->openConnection($this->authorityServerHost()))
					{
						if($csc->sendQuery("POST","/check/package/authority","body=".join('',file($this->getPath("packages").'/'.$pack.'/info.xml'))))
						{
							$answer=$this->decr($csc->readAnswer(),$key);
							if($answer!='200')
							{
								$error->internalError("packages","error while authentification proccess on external server","Package: ".$pack." authentification result ".$asnwer);
								return false;
							}else
							{
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}
	
	private function isDependent($child,$parent)
	{
		#CHECK LIKE COMMAND
		if(!$GLOBALS['database']->checkRowExists("packages",array("name"=>$child,"parent LIKE "=>$parent)))
		{
			$xml=new xml();
			$xml->init($this->getPath("packages").'/'.$child.'/info.xml');
			$extends=$xml->xpath_node("dependencies/extending/item");
			for($i=0;$i<count($extends);$i++)
			{
				if($extends[$i]['name']==$parent) return true;
			}
		}else{
			return true;
		}
		return false;
	}
	
	private function checkDependencies($pack,$xml)
	{
		$err=0;
		$errors=new Errors();
		if(is_object($xml))
		{
			#die_R($xml);
			$dep=array();
			$dep['extending']=$xml->xpath_node("dependencies/extending/item");
			$dep['interfaces']=$xml->xpath_node("dependencies/interfaces/item");
			$dep['libs']=$xml->xpath_node("dependencies/libs/item");
			$dep['abstractions']=$xml->xpath_node("dependencies/abstractions/item");
			$dep['errors']=$xml->xpath_node("dependencies/errors/item");
			for($i=0;$i<count($dep['extending']);$i++)
			{
				$ob=(String)$dep['extending'][$i]['name'];
				if(!$this->packageExists($ob))
				{
					$errors->internalError("packages","base package is not exists","Destination package: ".$package." base: ".$ob);
					$err=1;
				}else
				{
					#if($this->isDependent($pack,$ob))
					#{
					##	$errors->internalError("packages","parent package cannot extending from the child package","Parent:".$ob." child: ".$pack);
					#	$err=1;
					#}
				}
			}
			
			for($i=0;$i<count($dep['abstraction']);$i++)
			{
				$ob=(String)$dep['abstractions'][$i]['name'];
				if(!file_exists($this->getPath("abstractions")."/".$ob."/abstractions.".$dep['abstraction'][$i]['name'].'.php'))
				{
					$errors->internalError("packages","abstraction class is not exists","Package: ".$pack." abstraction:".$dep['abstraction'][$i]['name']);
					$err=1;
				}
			}
			
			for($i=0;$i<count($dep['interfaces']);$i++)
			{
				$ob=(String)$dep['interfaces'][$i]['name'];
				if(!file_exists($this->getPath("interfaces")."/".$ob."/interfaces.".$ob.'.php'))
				{
					$errors->internalError("packages","interface to implement is not exists","Package: ".$pack." interfaces:".$ob);
					$err=1;
				}
			}
			for($i=0;$i<count($dep['errors']);$i++)
			{
				$ob=(String)$dep['errors'][$i]['name'];
				if(!file_exists($this->getPath("errors")."/".$ob."/errors.".$ob.'.php'))
				{
					$errors->internalError("packages","errors definitions is not exists","Package: ".$pack." errors:".$ob);
					$err=1;
				}
			}
			for($i=0;$i<count($dep['lib']);$i++)
			{
				$ob=(String)$dep['libs'][$i]['name'];
				if(!file_exists($this->getPath("libs")."/".$ob.'.php'))
				{
					$errors->internalError("packages","included lib is not exists","Package: ".$pack." lib:".$ob);
					$err=1;
				}
			}
		}else
		{
			$err=1;
		}
		return !$err;
	}
	
	private function packageExists($package)
	{
		return file_exists($this->getPath("packages")."/".$package."/package.".$package.".php");
	}
	
	private function checkParts($pack)
	{
		$path=$this->getPath("packages").'/'.$pack;
		$info=$path.'/info.xml';
		$xml=new xml();
		$xml->init($info,true);
		die_r($xml);
		if($parts=$xml->xpath_node("authority/includes"))
		{
			
		}
	}
	
	private function regPackage($pack)
	{
		$database=$GLOBALS['database'];
		$errors=new Errors();
		$result=false;
		$xml=new xml();
		if(!$this->packageRegistered($pack))
		{
			if($xml->init(parent::getPath("packages").'/'.$pack.'/info.xml'))
			{
				
				$data=$xml->getObject();
				#NEED TO add  $this->checkParts($pack,$xml)
				if($data->status=="off" || ($data->status!='off' && $this->checkDependencies($pack,$xml)))
				{
					$dep=serialize($xml->xpath_node("dependecies"));
					$parts=serialize($xml->xpath_node("authority/includes/item"));
					if($database->insertRow("packages",array("",$data->title,$pack,$data->version,$data->pubdate,$data->regcode,$data->company,$data->url,$parts,$dep,$data->bitsize,$md5,$data->license,$data->license_url,$data->status)))
					{
						return true;
					}else
					{
						$errors->internalError("packages","package registration error","Package: ".$pack,"critical");
					}
				}else
				{
					$errors->internalError("packages","package architecture error","Package:".$pack);
				}
			}else
			{
				$errors->internalError("packages","corepack information proceed error",'Package: '.$pack,"critical");
			}
		}
		return $result;
	}
	
	private function securityAlert($pack)
	{
		$security=&$GLOBALS['security'];
		$attempts=&$GLOBALS['attempts'];
		#$security->alarmOn();
	}
	
	public function init($path='')
	{
		if($path=='') $path=parent::getPath("packages");
		return $this->check_packages_index($path);
	}
	
	private function packageRegistered($pack)
	{
		return $GLOBALS['database']->checkRowExists("packages",array("name"=>$pack));	
	}
	
	private function indexSize()
	{
		return $GLOBALS['database']->getNumrows("SELECT * FROM `#prefix#_packages`");
	}
	
	private function _needCheck()
	{
		$d=opendir($this->getPath("packages"));
		$c=0;
		while(false!==($dir=@readdir($d)))
		{
			$c+=1;
		}
		if($c!=$this->indexSize())
		{
			return true;
		}else
		{
			if($database->getSQLParameter("settings","last_packages_indexation",1)-time()>3600*24*3)
			{
				return true;
			}
		}
		return false;
	}
	
	private function checkPackage($package)
	{
		$pack=$this->getPath("packages").'/'.$package;
		$errors=new Errors();
		if(file_exists($pack.'/info.xml') && file_exists($pack.'/package.'.$package.'.php'))
		{
			if(!$this->packageRegistered($package)) 
			{
				if(!$this->regPackage($package))
				{
					$errors->internalError("packages","package registration error","Package: ".$pack);
				}else
				{
					print "Package successful registered !<br/>";
				}
			}
			if(!$this->validatePackage($package))
			{
				$errors->internalError("packages","package validation error","Package".$pack);
				$this->securityAlert($package);
			}else
			{
					return true;
			}
		}
		return false;
	}
	
	private function check_packages_index()
	{
		$path=$this->getPath("packages");
		$d=opendir($path);
		$errors=new Errors();
		if($this->_needCheck())
		{
			while(false!==($dir=@readdir($d)))
			{
				if($dir!='.' && $dir!='..' && is_dir($path.'/'.$dir))
				{
					if(!$this->checkPackage($dir))
					{
						$errors->internalError("packages","package checking error","Package: ".$dir,"critical");
					}else{
						print "Package successful checked !<br/>";
					}
				}
			}
		}
		return false;
	}
}
?>