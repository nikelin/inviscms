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
$client=($client==-1)?$_SERVER['REMOTE_ADDR']:$client;
$errors=new Errors();
$q=$database->proceedQuery("DELETE FROM `#prefix#_basket` WHERE client='".$client."'");
if(!$database->isError())
{
	$errors->appendJSError("{^basket_cleared^}!");
	$errors->redirect('/basket/view');
}else{
	$errors->appendJSError("{^db_error^}!");
	$errors->redirect('/server_.html');
}
print $errors->outputData();
?>
