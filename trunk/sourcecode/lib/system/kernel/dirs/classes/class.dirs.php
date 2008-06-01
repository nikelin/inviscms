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
class dirs {

	public function clearDir($path){
		$errorB=new Errors();
		if(@file_exists($path)){
			$d=@opendir($path);
			while(false!==($sd=@readdir($d))){
				if(($sd!='.' && $sd!='..' && @is_file($path.'/'.$sd)) && !@unlink($path.'/'.$sd)){
					$errorB->appendJSError("directory clearing error");
				}
			}
		}else{
			$errorB->appendJSError("directory not exists");
		}
		if($errorB->isError()){
			print $errorB->outputData();
		}
	}
	
	public function deleteFile($file)
	{
		if(file_exists($file))
		{
			if(@unlink($file)){
				$result=true;
			}else{
				$result=false;
			}
		}else{
			$result=false;
		}
		return $result;
	}
	
	public function getFileFromPackage(PclZip $l,$name)
	{
		$result['xml']=null;
		$result['info']=$l->listContent();
		for($i=0;$i<count($result['info']);$i++)
		{
			if(strcmp($result['info'][$i]['filename'],$name)!=-1)
			{
				#print_r(strcmp($result['info'][$i]['filename'],'info.xml'));
				$result['xml']=$l->extractByIndex($result['info'][$i]['index'],PCLZIP_OPT_EXTRACT_AS_STRING);
				$result['xml']=$result['xml'][0]['content'];
			}
		}
		return $result;
	}
	
	public function validFileNFO(SimpleXMLElement $data){
		$result=false;
		if(@$data->file)
		{
			for($i=0;$i<count($data->file);$i++)
			{
				if(isset($data->file[$i]->dir))
					if(isset($data->file[$i]->description))
						if(isset($data->file[$i]->name))
							if(isset($data->file[$i]['name']))
								$result=true;
			}
		}	
		return $result;
	}
	
	public function getFileNamePart($name,$part="ext")
	{
		$name=basename($name);
		return (join('',array_slice(explode(".",$name),($part=="ext")?-1:0,1)));
	}
	
	public function packetLoad($file,$cat=0)
	{
		#die_r($cat);
		$database=&$GLOBALS['database'];
		$pclzip=&$GLOBALS['pclzip'];
		$result=null;
		
		if(file_exists($file) && filesize($file)!=0)
		{
			$pclzip->init($file);
			$info=$pclzip->listContent();
			if(is_array($info))
			{
				$result=array();
				for($i=0;$i<count($info);$i++)
				{
					$data=$pclzip->extractByIndex($info[$i]['index'],PCLZIP_OPT_EXTRACT_AS_STRING);
					if(is_array($data))
					{
						$data=$data[0];#die_r($this->getFileExt($data['filename']));
						#die_r($data);
						$ext=$this->getFileNamePart($data['filename'],"ext");
						$name=$this->getFileNamePart($data['filename'],"!ext");

						$src=$this->writeFile('./lib/files',$ext,join('',file('./PCLZIP_OPT_EXTRACT_AS_STRING/'.$name.'.'.$ext)));
						if(!$database->checkRowExists("files",array("name"=>$name)))
						{
							$q=$database->insertRow("files",array("",$cat,$ext,$name,$src,time(),$data['size'],$data['comment'],$this->checkFileType($data['filename']),'on'));
							if($database->isError())
							{
								die('AAAAAAA!!!!!! Error!!!!!! Help ME!!!!!');
							}else{
								$result[]=$name;
							}
						}else
						{
							$result[]=$name;
						}
					}else
					{
						die("Error!");
					}
				}
			}else
			{
				die("Error!");
			}
		}else
		{
			die("Error!");
		}
		return $result;
	}
	
	public function checkFileType($file)
	{
		$result=null;
		$ext=$this->getFileNamePart($file,"ext");
		switch($ext){
			case 'png':
			case 'jpeg':
			case 'gif':
			case 'bmp':
			case 'jpg':$result='image';break;
			case 'txt':$result='text';break;
			case 'nfo':
			case 'doc':
			case 'odt':
			case 'swx':
			case 'rtf':$result='document';break;
			default:$result='binary';break;
		}
		return $result;
	}
	
	public function uploadfile($path)
	{
		$system=&$GLOBALS['system'];
		$result=false;
		if(file_exists($path))
		{
			$genName=md5(time());
			  $name=explode('.',$path);
			  $ext=$name[1];
			  $filePath=$system->getPath("files").'/'.$genName.'.'.$ext;
			 
			  if(copy($path,$filePath))
			  {
			  	$result=$genName.'.'.$ext;
			  }
		}
		return $result;
	}
	
	public function makeFile($path,$data)
	{
		if(@file_exists($path))
		{
			if(false!==($fp=@fopen($path,'w+')))
			{
				return (@fwrite($fp,$data));
			}
		}
		return false;
	}
	
	public function writeFile($path,$ext,$data)
	{
		$result='error';
		if(file_exists($path) && is_writable($path))
		{
			$path=$path.'/'.md5(time()+mt_rand(0,100+mt_rand(1,5))).'.'.$ext;
			if(false!==($fp=fopen($path,'w+')))
			{
				if(false!==fwrite($fp,$data)){
					$result=$path;
				}
			}
		}
		return $result;
	}
	
	public function mkfile($path)
	{
		if(@file_exists($path) && @is_writable($path))
		{
			return (false!=(@fopen($path,'w+')));
		}else{
			return false;
		}
	}
	
	public function blockFile($file)
	{
		$result=false;
		if(@file_exists($file))
		{
			$dir=@dirname($file);
			$f=@basename($file);
			if(@is_writable($dir)){
				if(!($fp=@fopen($dir.'/'.md5($f).'.lock','w+'))){
					$result=false;
				}else{
					$result=true;
					@fclose($fp);
				}
			}else{
				$result=false;
			}
		}else{
			$result=false;
		}
		return $result;
	}
	
	public function isBlocked($file)
	{
		$result=false;
		if(@file_exists($file))
		{
			$dir=@opendir(dirname($file));
			$fl=@basename($file);
			while(false!==($f=@readdir($dir)))
			{
				if(md5($fl)==$f){
					$result=true;
				}else{
					$result=false;
				}
			}
		}else{
			$result=true;
		}
		return $result;
	}

	public function getContents($path,$type)
	{
		$result=array();
		if(@file_exists($path)){
			$dir=@opendir($path);
			while(false!==($el=@readdir($dir)))
			{
				if($el!='.' && $el!='..'){
					switch($type)
					{
						case 'file': if(@is_file($path.'/'.$el))@array_push($result,$el);break;
						case 'dir': if(@is_dir($path.'/'.$el))@array_push($result,$el);break;
					}
				}
			}
		}else{
			die("Path is wrong !");
		}
		return $result;
	}
}
//2008-01-03 17:39 $GMT+2
?>
