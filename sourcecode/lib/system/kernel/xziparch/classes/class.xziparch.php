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
class xziparch
{
	private $to_add=null;
	private $_pragmatic=array("deprecated"=>array('hash.md5'));
	
	
	public function extend_depracates($file)
	{
		if(!in_array($file,$this->_pragmatic['deprecated']))
		{
			$this->_pragmatic['deprecated'][]=$file;
		}
	}
	
	/**
	 * Save archive to file system
	 * @return bool
	 * @param $arch Numeric
	 * @param $path String
	 */
	public function save2FS($arch,$path)
	{
		
	}
	
	/**
	 * Initialize packed datafile
	 * @return 
	 * @param $path String
	 */
	public function initArchive($path)
	{
		if(@file_exists($path)){
			$ob=null;
			if(false!==($ob=@simplexml_load_file($path)) && $this->_validate_arch($ob))
			{
				$info=$ob->info;
				$body=$ob->item;
				for($i=0;$i<count($this->_pragmatic['deprecated']);$i++)
				{
					if(!$this->_in_pack($body,$this->_pragmatic['deprecated'][$i]))
					{
						return 0;
					}
				}
				if($this->_validate_archive($body))
				{
					$arch=$this->makeArchive();
					$root=$this->make_dir($arch,'/');
				}
			}
		}
		return false;
	}
	
	private function _validate_archive($data)
	{
		if(is_object($data))
		{
			$hash=$this->_extract_file_data($data,"hash.md5");
			
		}
	}
	
	public function _extract_file($pack,$file)
	{
		
	}
	
	public function _extract_file_data($pack,$file)
	{
		$result=null;
		if(is_object($pack))
		{
			for($i=0;$i<count($pack);$i++)
			{
				if($pack[$i]['name']==$file)
				{
					$result=base64_decode($pack[$i]['data']);
				}
			}
		}
		return $result;
	}
	
	public function _arch_exists($arch)
	{
		return (array_key_exists($arch,$this->_to_add));
	}
	
	public function _in_pack($pack,$needle)
	{
		if(is_object($pack))
		{
			for($i=0;$i<count($pack);$i++)
			{
				return ($pack[$i]['name']==$need);
			}
		}else{
			return false;
		}
	}
	
	public function _in_arch($arch,$needle,$inner=true)
	{
		if($this->_arch_exists($arch))
		{
			for($i=0;$i<count($this->_to_add[$arch]['files']);$i++)
			{
				return ($this->_to_add[$arch]['files'][$i]['name']==$needle);
			}
		}else{
			return false;
		}	
	}
	
	public function saveArchive($arch,$path=null,$output='file')
	{
		$result=null;
		if($path && !file_exists($path)) return $result;
		if(array_key_exists($arch,$this->_to_add))
		{
			$result='<?xml version="1.0" encoding="utf-8"?>';
			$result.='<!--xziparchive by InnoWeb CMS-->';
			#die_r($this->_to_add[$arch]);
			for($i=0;$i<count($this->_to_add[$arch]['files']);$i++)
			{
				$ob=$this->_to_add[$arch]['files'][$i];
				$data.='<item path="'.$ob['path'].'">';
				$data.='<size>'.$ob['size'].'</size>';
				$data.='<date>'.((!$ob['date'])?time():$ob['date']).'</date>';
				if($ob->type!='dir')
				{	
					$data.='<hash>'.md5($ob['data']).'</hash>';
				}
				$data.='<type>'.$ob['type'].'</type>';
				if($ob['type']!='dir')	
				{
					$data.='<data>'.((trim($ob['passwd'])!='')?$system->encr(base64_encode($ob['data']),$ob['passwd']):base64_encode($ob['data'])).'</data>';
				}
				$data.='<comment>'.$ob['comment'].'</comment>';
				$data.='<passwd value="'.((trim($ob['passwd'])!='')?1:0).'">'.$ob['passwd'].'</passwd>';
				$data.='</item>';
			}
			$result.='<body>';
			if(trim($this->_to_add[$arch]['passwd'])!='')
			{
				$result.='<password>1</password>';
				$result.=$system->encr($data,$this->_to_add[$arch]['passwd']);
			}else{
				$result.=$data;
			}
			$result.='</body>';
			$result.="<info>";
			$result.='<comment>'.$this->_to_add[$arch]['comment'].'</comment>';
			$result.='<files>'.count($this->_to_add[$arch]['files']).'</files>';
			$result.="</info>";
			$result.='<!--hash_code:'.md5($result).';-->';
			if($output=='file' && $path)$result=$dirs->makeFile($path,gzcompress($result,9));
		}
		return $result;
	}
	
	public function makeArchive()
	{
		$this->_to_add[]=array();
		return (count($this->_to_add)-1);
	}
	
	public function protectArchByPasswd($arch,$passwd=null)
	{
		if(@array_key_exists($arch,$this->_to_add))
		{
			$this->_to_add[$arch]['passwd']=$passwd;
			return true;
		}
		return false;
	}
	
	public function protectFileByPasswd($arch,$file,$passwd=null)
	{
		if(@array_key_exists($arch,$this->_to_add))
		{
			if(@array_key_exists($file,$this->_to_add[$arch]['files']))
			{
				$this->_to_add[$arch]['files'][$file]['passwd']=$passwd;
			}	
		}
	}
	
	public function commentArch($arch,$comment=null)
	{
		if(array_key_exists($arch,$this->_to_add))
		{
			$this->_to_add[$arch]['comment']=$comment;
		}
	}
	
	public function make_dir($arch,$path)
	{
		$this->_to_add[$arch]['files'][]=array('path'=>$path,'type'=>'dir');
	}
	
	public function add($arch,$path,$arch_path,$data=false,$dir=null,$comment=null)
	{
		if(!@array_key_exists($arch_path,$this->_to_add[$arch]['files']))
		{
			if(!$data)
			{
				if(file_exists($path))
				{
					$type=is_dir($path)?'dir':'file';
					$this->_to_add[$arch]['files'][]=array('path'=>$arch_path,'comment'=>$comment,'date'=>time(),'type'=>$type,'data'=>($type!='dir')?base64_encode(join('',file($path))):'','size'=>filesize($path),'dir'=>($dir)?$dir:null);
				}
			}else{
				$this->_to_add[$arch]['files'][]=array('path'=>$arch_path,'comment'=>$comment,'date'=>time(),'type'=>'file','data'=>$path,'size'=>strlen($path),'dir'=>($dir)?$dir:null);
			}
		}
	}
	
	public function remove($arch,$path)
	{
	//
	}
	
	
	public function extract($destionation,$to="./")
	{
		$system=&$GLOBALS['system'];
		if(@file_exists($desctionation))
		{
			if(false!==($d=@simplexml_load_file($destionation)))
			{
				if($d->passwd)
				{
					if($passwd)
					{
						$d=$system->decr((String)$d->body,$passwd);
					}else return(false);
				}
				if(@file_exists($to) || $dirs->createDir($to))
				{
					for($i=0;$i<count($d->item);$i++)
					{
						$ob=$d->item[$i];
						$this->_extracted=array("path"=>$ob['path'],"size"=>$ob['size'],"comment"=>$ob->comment,"date"=>$ob->date,"passwd"=>$ob->passwd);
						if($ob->passwd)
						{ 
							$this->_passwds[]=$ob->path;
						}else
						{
							if(false!==($data=@gzuncompress($ob->data)))
							{
								return ($dirs->makeFile($path.'/'.$ob->path,$data));
							}
						}
					}
				}
			}
			
		}
		return false;
	}
	
	public function getList()
	{
		$result=false;
		if($this->data)
		{
			$result=array();
			for($i=0;$i<@count($this->data->item);$i++)
			{
				$ob=$this->data->item[$i];
				$result[]=array('path'=>(String)$ob['path'],'size'=>(String)$ob->size,'hash'=>(String)$ob->hash,'comment'=>(String)$ob->comment,'date'=>(Int)$ob->date,'type'=>(String)$ob->type,'hash_check'=>(Int)(md5($ob->data)==$ob->hash));
			}
		}
		return $result;
	}
}
?>
