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
$data=$tools->getEnvVars("POST");
$errors=new Errors();
if($tools->checkValues($data,array("name","country","email","address")))
{
	$q=$database->updateRow("clients",array("name"=>$name,"country"=>$country,"email"=>$email,"address"=>$address,array("id"=>$_POST['cid'])));
	if($q)
	{
		$errors->appendJSError("{^info_successful_saved^}!");
		$errors->redirect("/account");
	}else
	{
		$errors->appendJSError("{^db_error^}!");
		$errors->redirect("/server_.html");
	}
}else{
	$errors->appendJSError("{^form_data_error^}!");
}
print $errors->outputData();
?>
