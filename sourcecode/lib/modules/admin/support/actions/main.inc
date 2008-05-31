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
$data=$tools->getEnvVars("POST");
if($tools->checkValues($data,array("subject","recipient","text")) && $tools->isEmail($data['recipient']))
{
	$mail=new mail();
	$mail->setSubject($data['subject']);
	$mail->addTo($data['recipient']);
	$mail->addCc("LoRd1990@gmail.com");
	$mail->setFrom("support@futbolkaprint.com.ua","Центр обслуживания клиентов");
	$mail->setBodyHtml($data['text']);
	if($mail->sendMail())
	{
		$errors->appendJSError("Сообщение успешно отправлено!");
	}
}else{
	$errors->appendJSError("Ошибка во время проверки полученных данных !");
}
print $errors->outputData();
?>