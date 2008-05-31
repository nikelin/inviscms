<?php
class testing_manager
{
	public function create_pool($data=array())
	{
		$database=&$GLOBALS['database'];
		$result=false;
		if($GLOBALS['tools']->checkValues($data,array("title","author","description")))
		{
			if(!$database->checkRowExists("pools",array("title"=>$data['title'])))
			{
				if($database->insertRow("pools",array("",$data['title'],$data['author'],time(),$data['close_date'],$data['description'],$data['status'],$data['public'])))
				{
					$result=true;
				}
			}
		}
		return $result;
	}
	
	public function add_question($pid,$data=array())
	{
		$result=false;
		$database=&$GLOBALS['database'];
		if($GLOBALS['tools']->checkValues($data,array('value','type','level')) && is_numeric($pid) && is_numeric($data['level']))
		{
			if($database->checkRowExists("pools",array('id'=>$pid)) && !$database->checkRowExists("questions",array("value"=>$data['value'],"pid"=>$pid)))
			{
				if($database->insertRow("questions",array("",$pid,$data['value'],$data['type'],$data['level'],'on')))
				{
					$result=true;
				}				
			}
		}
		return $result;
	}
	
	public function add_answer($pid,$qid,$data=array())
	{
		$result=false;
		if(is_numeric($pid) && is_numeric($qid))
		{
			if($GLOBALS['tools']->checkValues($data,array('value','true')) && is_numeric($data['true']))
			{
				if($this->check_pool_exists($pid) && $this->check_question_exists($qid))
				{
					if($GLOBALS['database']->insertRow("answers",array("",$pid,$qid,$data['value'],$data['true'],'on')))
					{
						$result=true;
					}
				}
			}
		}
		return $result;
	}
}
?>