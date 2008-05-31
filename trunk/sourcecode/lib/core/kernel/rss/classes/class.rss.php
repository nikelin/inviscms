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
class rss
{
	public function create_feed($source,$data=array())
	{
		$tools=&$GLOBALS['tools'];
		if($tools->isURL($source))
		{
			//URL-context
		}else
		{
			//Table-context
		}
	}
	
	public function render_feed($source,$data=array("pubdate"=>"","title"=>"","description"=>"","author"=>""),$count=-1)
	{
		$result=null;
		$database=&$GLOBALS['database'];
		if($database->_tableExists($source))
		{
			$pubdate=(isset($data['pubdate']) && trim($data['pubdate'])!='')?$data['pubdate']:time();
			if(@$data['title'] && @$data['description'])
			{
				#$q=$database->getRows($source,array($pubdate,
			}
		}		
	}
	//-1 - infinity
	
	
	public function show_external_feed($url,$count=-1){}//-1 - infinity
	public function proceed_feed($source){}
	
}
?>