<?php
class cronjobs
{
	
	public function newJob($name,$type,$data,$hourse)
	{
		$database=&$GLOBALS['database'];
		if(!$database->checkRowExists("cronjobs",array("name"=>$name)))
		{
			if(!$database->insertRow("cronjobs",array("",$name,$type,$data,$hourse,time(),"on")))
			{
				return true;
			}
		}
		return false;
	}
	
	public function doJobs()
	{
		$database=&$GLOBALS['database'];
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_cronjobs` WHERE status='on'");
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				while($row=$database->fetchQuery($q))
				{
					$hourse=explode('::',$row['hourse']);
					if(in_array(date("H"),$hourse))
					{
						if($row['type']=="url")
						{
							if(file($row['data']))
							{
								return true;
							}
						}else
						{
							if(@eval($row['data']))
							{
								return true;
							}
						}
						$q=$database->updateRow("cronjob",array("lcall"=>time()),array("id"=>$row['id']));
					}
				}
			}
		}
		return false;
	}
	
	public function deleteJob($id)
	{
		return $GLOBALS['database']->deleteRow("cronjobs",array("id"=>$id));
	}
	
	public function editJob()
	{
		
	}
	
}
?>