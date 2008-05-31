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
	$errors=new Errors();
    $id=$GLOBALS['params']['params'][1];
	$client=$clients->getUID();
	$client=($client!=-1)?$client:$_SERVER['REMOTE_ADDR'];
	if(strlen($id)==6)
	{
		if($basket->remove($client,$id))
		{
			$errors->appendJSError("{^product_deleted^}!");
			$errors->redirect("/basket/view");
		}else{
			$errors->appendJSError("{^some_error^}!");
			$errors->redirect("/server_.html");
		}
	}else{
		$errors->appendJSError("{^params_data_error^}!");
		$errors->redirect("/basket/view");
	}
	print $errors->outputData();
?>
