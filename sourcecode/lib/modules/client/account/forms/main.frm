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
$rs=new Errors();
if($security->authorized("client"))
{
	$module=isset($GLOBALS['params']['params'][0])?$GLOBALS['params']['params'][0]:'home';
	switch($module){
		case 'orders':
		case 'moveitems':
		case 'profile':
		case 'home':
		case 'club':
			@include './lib/modules/client/account/forms/'.$module.'.frm';
			break;
	}
}else
{
	$rs->appendJSError("Вы не авторизированы !");
	$rs->redirect("/form/auth_form");
}
print $rs->outputData();
?>
