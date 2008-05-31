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
	$frmB=new forms();
	$frmB->init("POST","","","userReg");
	$fls=array();
    $frmB->addLegend("Новый пользователь");
	$fls['ip']=$frmB->addField("Your current IP-address:","pair",$_SERVER['REMOTE_ADDR']);
	$fls['email']=$frmB->addInput("text","email",$frmB->addField("Enter your e-mail:","pair"));
	$frmB->addSubmit("action_main","Создать аккаунт",array("style"=>"width:100%;"));
	print $frmB->render(true);
?>