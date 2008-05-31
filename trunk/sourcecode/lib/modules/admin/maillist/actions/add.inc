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
switch($data['type'])
{
	case 'gmail':
		if(trim($data['login']=='') || trim($data['passwd'])=='')
		{
			$errors->appendJSError("Вы не ввели логин либо пароль!");
		}else{
			$csc->openConnection("google.com","ssl",80);
			$csc->sendQuery("/accounts/ClientLogin/?accountType=GOOGLE&Email=LoRd1990@gmail.com&Passwd=d123456&service=cl&
   source=InnoWeb CMS","POST");
   			print $csc->readAnswer();
		}
		break;
}
?>
