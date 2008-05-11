<?php
class logs_controller
{
	#
	# System settings
	#
	private $output_method="file";//('file'|'email'|'both')
	private $save_method="single_file"; //('signle_file'|'diffent_files')
	private $log_name_mask='data.%md5(time())%.log';
	private $max_history_size=2000000;//in bites
	private $compress_wrapper_function='gzcompress';//empty to turn `off` compressing
	
	#
	# Datafields
	#
	private $clg=null;//Current logs_event object
	
	public function proceed_event($logs_event)
	{
		if(get_classname($logs_event)=="logs_event")
		{
			$this->clg=$logs_event;
			$this->save_event();
			$this->clear_history();
			//instructions
		}else
		{
			
		}
	}
	
	private function send_notification()
	{
	}
}
?>