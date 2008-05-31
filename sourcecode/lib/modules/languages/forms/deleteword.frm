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
#die_r($GLOBALS['params']['params']);
$id=$GLOBALS['params']['params'][3];
$did=$GLOBALS['params']['params'][2];
if(!is_numeric($id))
{
    $errors->appendJSError("Ошибка при проверке параметров!");
    $errors->redirect("/admin/languages/main");
}else
{
    if(!$database->checkRowExists("texts",array("id"=>$id)))
    {
        $errors->appendJSError("Данное слово не существует в базе данных !");
        $errors->redirect('/admin/languages/main');
    }else
    {
        if(!$database->deleteRow("texts",array("id"=>$id)))
        {
            $errors->appendJSError("Ошибка во время диалога с БД!");
            $errors->redirect("/server_.html");
        }else
        {
            $errors->appendJSError("Слово успешно удалено!");
            $errors->redirect("/admin/languages/edit/".$did);
        }
    }
}
print $errors->outputData();
?>