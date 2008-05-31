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
$error=new Errors();
$data=$tools->getEnvVars("POST");
$langs=$i18n->getLangs();
$multi=$i18n->prepareMultilingual($i18n->extractMultilingualFields($data));
$q=$database->updateRow("settings",array(
									"site_title"=>$multi['sitetitle']['data'],
									"lang"=>$data['lang'],
									"site_skin"=>$data['siteskin'],
									"site_keywords"=>$multi['sitekeywords']['data'],
									"site_description"=>$multi['sitedescription']['data'],
									"site_closed"=>isset($data['siteclosed'])?'on':'off',
									"reply_to"=>$data['replyto'],
									"default_charset"=>$data['defaultcharset'],
									"main_path"=>$data['mainpath'],
									"paykey"=>$data['paykey'],
									"email"=>$data['email'],
									"icq"=>$data['icq'],
									"telephone"=>$data['telephone']
									));
if($database->isError())
{
	$error->appendJSError("Ошибка во время диалога с БД !".$database->sqlErrorString());
	$error->redirect("/server_.html");
}else{
	$error->appendJSError("Информация успешно сохранена !");
}
print $error->outputData();
?>