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
if(isset($_POST['action'])){
	if(@include_once($GLOBALS['path_to_site'].'/lib/core/others/forms/'.$_POST['action'].'.inc')){
		
		if(call_user_func($_POST['action'].'_main',&$_POST)==200)
		{
			print call_user_func($_POST['action'].'_success');
		}else{
			print call_user_func($_POST['action'].'_error');	
		}
	}
}else{
	die_r('Внутренняя ошибка системы!');
}
?>
