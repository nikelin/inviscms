<?php
interface voting
{
	public function create_pool($title,$uid,$description,$access);
	public function append_question($tid,$title,$type){}
	public function append_answer($tid,$qid,$value,$true=false);
	public function set_choice($uid,$test_id,$quest_id,$answer_id);
	public function finish_test($uid,$tid);
	public function get_results($uid,$tid);
}
?>