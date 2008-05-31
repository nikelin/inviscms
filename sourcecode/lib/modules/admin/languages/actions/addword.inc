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
if(!$tools->checkValues($data,array("title","dict","name")))
{
    $errors->appendJSError("Ошибка во время проверки переданных данных !");
    $errors->redirect("/admin/languages/addword");
}else{
    if(!$database->checkRowExists("dicts",array("id"=>$data['dict'])))
    {
        $errors->appendJSError("Данный словарь не существует !");
        $errors->redirect("/admin/languages/main");
    }else
    {
        if($database->checkRowExists("texts",array("param"=>$data['dict'],"partition"=>"dicts","name"=>$data['name'])))
        {
            $errors->appendJSError("Данное слово уже присутствует в словаре!");
            $errors->redirect("/admin/languages/addword");
        }else{
            $rid=$database->insertRow("texts",array("",$data['name'],$data['value'],'dicts',$data['dict']));
            if($database->isError())
            {
                die_r($database->sqlErrorString());
                $errors->appendJSError("Ошибка во время диалога с БД!");
                $errors->redirect("/server_.html");
            }else{
                $errors->appendJSError("Слово успешно добавлен в словарь под №".$rid."!");
                $errors->redirect("/admin/languages/edit/".$data['dict']);
            }
        }
    }
}
?>