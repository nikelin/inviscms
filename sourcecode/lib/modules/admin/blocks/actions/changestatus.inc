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
$type=isset($GLOBALS['params']['params'][2])?$GLOBALS['params']['params'][2]:die("Переданы неверные параметры");
$id=isset($GLOBALS['params']['params'][3])?$GLOBALS['params']['params'][3]:die("Переданы неверные параметры");
if(is_numeric($id) && $id>=0 && trim($type)!='')
{
    if($database->checkRowExists("blocks",array("id"=>$id)))
    {
        $q=$database->updateRow("blocks",array("status"=>($type=="deny")?"off":"on"),array("id"=>$id));
        if(!$database->isError())
        {
            $errors->appendJSError("Блок успешно ".(($type=="deny")?"заблокирован":"разблокирован");
        }else{
            $errors->appendJSError("Ошибка во время диалога с БД!");
        }
    }else{
        $errors->appendJSError("Блок не существует!");
    }
}else{
    $errors->appendJSError("Переданы неверные параметры!");
}
print $errors->outputData();
?>