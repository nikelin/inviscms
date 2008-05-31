<?php
	/**
	 * Class what implements simple operations to
	 * provide database query caching.
	 * Save information until:
	 * 	1. Size of database information will not be change  
	 * 	 2. Number of rows in table will not be change
	 *  3. Table columns description will not be change 
	 */
	class dbcache
	{
		
		// Path to the directory with temprorary files
		public $cache_dir='';
		
		/**
		 * Main class contructor
		 * @return 
		 * @param $query String[optional]
		 */
		public function __construct($query='')
		{
			$this->cache_dir=$GLOBALS['tmp_dir'].'/dbcache';
			if(trim($query)!='')
				return $this->proceed($query);
		}
		
		public function proceed($table,$query)
		{
			$result=null;
			// Check that query can only read
			if(preg_match("/SELECT/",$query))
			{
				// Make pairs hash
				$hash=md5($query);
				 // Check that this query was cached in past
				if($this->exists($hash))
				{
					// Validate 
					$result=$this->get($hash);
					if($this->validate($hash,$result))
					{
						// Nothing to do?...
					}else
					{
						// Renew cache
						$result=$this->remember($hash,$this->fetch($query));
					}
				}else{
						// Generate cache
						$result=$this->remember($hash,$this->fetch($query));
				}
			}
			return $result;
		}
		
		private function fetch($query)
		{
			return $GLOBALS['database']->fetchQuery($GLOBALS['database']->proceedQuery($query));
		}
		
		private function get($qid)
		{
			$result=null;
			$path=$this->cache_dir.'/'.$qui.'.tmp';
			if(file_exists($path))
			{
				$result=unserialize(gzuncompress(file_get_contents($path)));
			}
			return $result;
		} 
		
		private function remeber($table,$hash,$data)
		{
			$result=false;
			$path=$this->cache_dir.'/'.$hash.'.tmp';
			$data=serialize(array("info"=>$this->getObjectInfo($table),"data"=>$data));
			if($fp=@fopen($path,'w+'))
			{
				@flock($fp,LOCK_EX);
				if(@fwrite($fp,gzcompress($data)))
				{
					$result=true;
				}
				@flock($fp,LOCK_UN);
				@fclose($fp);
			}
			return $result;
		}
		
		public function clear()
		{
			return $GLOBALS['dirs']->clearDIr($this->cache_dir);
		}
		
		private function validate($hash,$table,$cache_result)
		{
			$data=unserialize(gzuncompress($cache_result));
			if(isset($data['info']) && isset($data['data']))
			{
				
			}
		}
	}
?>