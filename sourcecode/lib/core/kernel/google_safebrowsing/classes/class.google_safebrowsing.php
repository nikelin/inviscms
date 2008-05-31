<?php
define("GOOGLE_BH","goog-black-hash");
define("GOOGLE_MW","goog-malware-hash");
class google_safebrowsing
{
	private $_api_key="ABQIAAAAacIy9qucnsAa6PVosnY3KhTOlcWORPOLnPPaRCcvsAgbrh6s5Q";
	private $_gateway="http://sb.google.com/safebrowsing";
	private $_tmp_path=array(
										"google-black-hash"=>'google_sb_bh.tmp',
										"google-malwave-hash"=>'google_sb_mw.tmp'
										);
	
	public function __construct()
	{
		foreach($this->_tmp_path as $k=>$v)
		{
			$this->_tmp_path[$k]=$GLOBALS['site_path'].'/lib/temp/'.$v;
		}
	}
	
	private function _is_h_actual($type=GOOGLE_BH)
	{
		if(file_exists($this->_tmp_path[$type]) && (time()-filemtime($this->_tmp_path[$type])<0))
		{
			return true;
		}
		return false;
	}
	
	public function check($addr,$type=GOOGLE_BH)
	{
		$result=false;
		if($this->_is_h_actual())
		{
			if($fp=@fopen($this->_tmp_path['type'],'r'))
			{
				@flock($fp,LOCK_EX);
				while($line=fgets($fp,40))
				{
					if(preg_match('/['.md5($addr).']+/',$line))
					{
						$result=true;
						break;
					}
				}
				@flock($fp,LOCK_UN);
				@fclose($fp);
			}		
		}else
		{
			if($this->renew_cache())
				$result=$this->check($url);
		}
		return $result;
	}
	
	private function renew_cache($type=GOOGLE_BLASK_HASH)
	{
		$csc=&$GLOBALS['csc'];
		$result=false;
		if($conn=$csc->openConnection($this->_gateway))
		{
			if($csc->sendQuery("POST","/update",array("client"=>"api","apikey"=>$this->_api_key,"version"=>$type)))
			{
				$csc->closeConnection();
				$this->_write_new_cache($csc->readAnswer(),$type);
				$result=true;
			}
		}
		return $result;
	}
	
	private function _write_new_cache($data,$type=GOOGLE_BH)
	{
		$result=false;
		if($fp=@fopen($this->_tmp_path[$type],"w+"))
		{
			@flock($fp,LOCK_EX);
			if(@fwrite($fp,$data))
			{
				$result=true;
			}
			@flock($fp,LOCK_UN);
			@fclose($fp);
		}
		return $result;
	}
	
	public function request($url,$type="fishing")
	{
		
	}
	
	private function getkey()
	{
		$csc=&$GLOBALS['csc'];
		$result=null;
		if($conn=$csc->openConnection($this->_gateway))
		{
			if($csc->sendQuery("POST","/getkey",array("client"=>$client)))
			{
				$data=explode("\n",$csc->readAnswer());
				for($i=0;$i<count($data);$i++)
				{
					$d=explode(":",$data[$i]);
					$result[$d[0]]=$d[1];
				}
				$csc->closeConnection();
			}
		}
		return $result;
	}
	
	
}
?>