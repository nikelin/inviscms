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
class advertising
{
	
	public function getlist($count=0){}
	
	public function show()
	{
		$database=&$GLOBALS['database'];
		$html=&$GLOBALS['banners'];
		$result=null;
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_advertising`
									WHERE status='on' AND views>=0
									AND (SELECT COUNT(id) AS count FROM `#prefix#_client` 
										WHERE id=uid AND status='off')=0
									ORDER BY RAND()
									LIMIT 0,1
									");
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				$data=$database->fetchQuery($q);
				$this->view($data['id']);
				$result=$html->render_banner($data);
			}
		}
		return $result;
	}
	
	public function view($bid)
	{
		$database=&$GLOBALS['database'];
		$result=false;
		if(is_numeric($bid))
		{
			$q=$database->updateRows("banners",array("views"=>"views-1"),array("id"=>$bid));
			if(!$database->isError())
			{
				$result=true;
			}
			$this->check_status($bid);
		}
		return $result;
	}
	
	public function click($bid){}
	public function status($bid,$value='on'){}
	public function check_status($bid){}
	public function send_notify($bid){}
	
}
