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
class persmissions extends database
{
	
	public function setAccessMode($uid,$mode)
	{
		$result=false;
		if($this->checkRowExists("permissions",array("uid"=>$uid)) && $this->validMode($mode))
		{
			if($this->updateRow("permissions",array("mode"=>$mode),array("uid"=>$uid)))
			{
				$result=true;
			}
		}
		return $result;
	}
	
	public function createAccess($uid,$mid,$mode)
	{
		$result=false;
		if(!$this->checkRowExists("permissions",array("uid"=>$uid,"mid"=>$mid)))
		{
			if($this->insertRow("permissions",array("",$uid,$mid,$mode)))
			{
				$result=true;
			}
		}else
		{
			$result=$this->setAccessMode($uid,$mid,$mode);
		}
		return $result;
	}
	
	public function checkAccessMode($uid,$mid)
	{
		return $this->getSQLParameter("permissions","mode",array("uid"=>$uid,"mid"=>$mid));
	}
	
	public function denieAccess($uid,$mid)
	{
		return $this->updateRow("permissions",array("mode"=>"n"),array("uid"=>$uid,"mid"=>$mid));
	}
	
}
?>