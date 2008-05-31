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
$dat=$tools->getEnvVars("POST",true);
$errors=new Errors();
if(!$tools->checkValues($dat,array("dict")))
{
    $errors->appendJSError("Ошибка во время проверки данных формы!");
}else
{
    if(!$database->checkRowExists("dicts",array("id"=>$dat['dict'])))
    {
        $errors->appendJSError("Данный словарь не существует!");
    }else
    {
        if(!isset($_FILES['data']) || filesize($_FILES['data']['tmp_name'])==0)
        {
            $errors->appendJSError("Ошибка во время загрузки словаря!");
        }else{
            $data=simplexml_load_file($_FILES['data']['tmp_name']);
            if(!$data)
            {
                $errors->appendJSError("Ошибка во время обработки словаря!");
            }else{
                for($i=0;$i<count($data->item);$i++)
                {
                    if(trim($data->item[$i]['name'])!='')
                    {
                        $value=(String)(isset($data->item[$i]['value'])?$data->item[$i]['value']:$data->item[$i]);
                        if(!$database->checkRowExists('texts',array("partition"=>"dicts","name"=>(String)$data->item[$i]['name'],"param"=>$dat['dict'])))
                        {
                            if($database->insertRow('texts',array("",(String)$data->item[$i]['name'],rawurlencode($value),"dicts",$dat['dict'])))
                            {
                                $errors->appendJSError("Слово ".$data->item[$i]['name']." успешно добавлено!");
                            }else{
                                $errors->appendJSError("Ошибка во время диалога с БД!");
                            }
                        }else{
                                $q=$database->updateRow('texts',array('value'=>rawurlencode($value)),array("name"=>$data->item[$i]['name'],"partition"=>"dicts","param"=>$dat['dict']));
                                if(!$database->isError())
                                    $errors->appendJSError("Существующее слово ".(String)$data->item[$i]['name']." успешно изменено!");
                                else
                                    $errors->appendJSError("Ошибка во время диалога с БД!");
                            }
                        }
                    }
                }
            }
        }
    }
print $errors->outputData();
?>