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
$id=$GLOBALS['params'][1];
$count=$GLOBALS['params'][2];
$errors=new Errors();
$client=$clients->getUID();
$client=($client==-1)?$_SERVER['REMOTE_ADDR']:$client;
if(is_numeric($id) && is_numeric($count) && $id!=0 && $count!=0)
{
	if($basket->updateCount($client,$id,$count,'minus'))
	{
		$errors->redirect('/basket/view');
	}else{
		$errors->appendJSError("{^db_error^}!");
	}
}else{
	$errors->appendJSError("{^params_data_error^}!");
}
print $errors->outputData();
?>
