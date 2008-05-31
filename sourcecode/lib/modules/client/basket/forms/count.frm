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
$id=$GLOBALS{'params'}['params'][1];
$count=$GLOBALS['params']['params'][2];
if(is_numeric($id) && $id!=0 && is_numeric($count))
{
	$q=$database->updateRows("basket",array("count"=>$count),array("id"=>$id));
	if(!$database->isError())
	{
		$errors->appendJSError("{^info_successful_saved^}!");
		$errors->redirect("/basket/view");
	}else{
		$errors->redirect("/server_.html");
	}
}else{
	$errors->redirect("/basket/view");
}
print $errors->outputData();
?>
