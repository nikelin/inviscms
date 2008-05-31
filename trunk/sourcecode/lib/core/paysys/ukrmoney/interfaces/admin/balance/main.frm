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
$ukrmoney=new ukrmoney();
$errors=new Errors();
$ain=$this->getAuthInfo("ukrmoney");
if($ain){
	if(!$ukrmoney->auth($ain['login'],$ain['passwd']))
	{
		$errors->appendJSError("Ошибка во время авторизации в системе!");
		$errors->redirect("/admin/payment/ukrmoney/settings");
	}
}else{
	$errors->appendJSError("Ошибка во время чтения авторизационной информации!");
}
print $errors->outputData();
$balance=$ukrmoney->balance();
?>
<div class='form'>
	<div class='legend'>Баланс по счетам в системе UkrMoney</div>
		<?php
		for($i=0;$i<count($balance);$i++)
		{
		?>
		<div class='row'>
			<div class='label label1 center' style='width:100%;clear:both;'>Счёт №<?=$balance[$i]['id'];?></div>
		</div>
		<div class='row'>
			<div class='label'>Номер счета</div>
			<div class='value'><?=$balance[$i]['number'];?></div>
		</div>
		<div class='row'>
			<div class='label'>Валюта</div>
			<div class='value'><?=$balance[$i]['currency'];?></div>
		</div>
		<div class='row'>
			<div class='label'>Название счета</div>
			<div class='value'><?=$balance[$i]['name'];?></div>
		</div>
		<div class='row'>
			<div class='label'>Баланс на счету</div>
			<div class='value'><?=$balance[$i]['amount'];?></div>
		</div>
		<div class='row'>
			<div class='label submit'>
				<button onclick='Invis.core.loadPage("payment","sys/ukrmoney/transactions/<?=$balance[$i]['id'];?>")'>История транзакций</button>
			</div>
		</div>
	<?php
	}
	?>
</div>