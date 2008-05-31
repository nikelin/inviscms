<?php
class testing_render
{
	public function tests_list()
	{
		$database=&$GLOBALS['database'];
		$q=$database->fetchQuery($database->proceedQuery("SELECT
										#prefix#_pools.id AS id,
										#prefix#_pools.title AS title,
										#prefix#_pools.description AS description,
										#prefix#_pools.level AS level,
										#prefix#_pools.pubdate AS pubdate,
										#prefix#_pools.author AS author,
										COUNT(#prefix#_questions.id) AS qcount
									FROM `#prefix#_questions`, #prefix#_pools`
									WHERE
										#prefix#_pools.status='on' AND
										#prefix#_questions.pid=#prefix#_pools.id AND
										#prefix#_questions.status='on' AND
										(#prefix#_pools.closedate-UNIX_TIMESTAMP)>0 AND (#prefix#_pools.pubdate<UNIX_TIMESTAMP)
									"));
	}
	
	public function get_question($pid)
	{
		
	}
	
	public function get_answer($pid,$qid)
	{
		
	}
}
?>