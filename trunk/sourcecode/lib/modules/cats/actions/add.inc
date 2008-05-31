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
if($tools->checkValues($data,array("title")))
{
    $pid=(isset($data['pid']))?$data['pid']:-1;
    $q=$database->insertRow("cats",array("",$data['title'],$pid,"LAST_INSERT_ID()","on"));
    if($database->isError())
    {
        $errors->appendJSError("Ошибка во время диалога с БД!");
        $errors->redirect("/server_.html");
    }else{
        $errors->appendJSError("Категория успешно создана!");
        $errors->redirect("/admin/cats");
    }
}else{
    $errors->appendJSError("Ошибка во время проверки переданных данных!");
}
print $errors->outputData();
?>