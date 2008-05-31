<?php
class logs
{
	private $_output_method='both';  // 'email', 'file', or 'both'
	private $_save_method=1;   // 1 - different files, 0 - single log-file (appending new data)
	#private $_name_mask='(log.%s.gz):(date';  // printf()-compilance name:  (%mask):(%variables_names_list)
	private $_max_history_size=200000; // in bytes
	private $_compress_method='gzcompress'; // method to compress history data
	private $_uncompress_method='gzuncompress';  // back to compress method
	
	public function  new_event($event){}
	
	public function read_event($id){}
	
	private function save_event()
	{
		
	}
	
	private function gen_name(){}
	
	private function compress(){}
	
	private function decompress(){}
	
	private function creare_history(){}
	
	private function current_history_size(){}
	
	private function max_history_size(){}
}
?>