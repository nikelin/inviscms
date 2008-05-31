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
$data=$tools->getEnvVars("POST",true);
$errors=new Errors();
if(!$tools->checkValues($data,array("npasswd","cpasswd","npasswd_r")))
{
	$errors->appendJSError("{^form_wrong_data^}!");
	$errors->redirect("/account/profile");
}else
{
	if($data['npasswd']==$data['npasswd_r'])
	{
		$q=$database->proceedQuery("UPDATE `#prefix#_clients` SET passwd='".md5($data['npasswd'])."' WHERE id=".$data['cid']." AND passwd='".md5($data['cpasswd'])."'");
		die_r($database->getNumrows($q));
	}else{
		$errors->appendJSError("{^passwd_retype_error^} !");
		$errors->redirect("/account/profile");
	}
}
print $errors->outputData();
?>
