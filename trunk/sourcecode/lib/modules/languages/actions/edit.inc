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
    if(isset($_POST['action']) || !(isset($_POST['did'])))
    {
    	$data=$tools->getEnvVars("POST",true);
        if($database->checkRowExists("dicts",array("id"=>$data['did'])))
        {
            switch($data['action'])
            {
                case 'dict_title_change':
                    
                    if(!$database->updateRow("dicts",array("name"=>$data['name']),array("id"=>$data['did'])))
                    {
                        $errors->appendJSError("Ошибка во время диалога с БД!");
                    }else
                    {
                        $errors->appendJSError("Изменения успешно сохранены!");
                        if(!$database->updateRow("dicts",array("lchange"=>time()),array("id"=>$data['did'])))
						{
							$errors->appendJSError("Ошибка во время попытки обновления даты !");
							$errors->redirect("/server_.html");
						 }else{
							$errors->redirect("/admin/languages/edit/".$data['did']);
						 }
					}
                break;
                case 'save':
                    for($i=0;$i<count($data['name']);$i++)
                    {
                        if(trim($data['name'][$i])!='' && trim($data['text'][$i])!='')
                        {
                            if(!$database->updateRow("texts",array("value"=>$data['text'][$i],"name"=>$data['name'][$i]),array("partition"=>"dicts","param"=>$data['did'],"id"=>$data['id'][$i])))
                            {
                                $errors->appendJSError("Ошибка во время сохранения слова под №".$data['id'][$i]."!");
                            }else{
                            	#$errors->appendJSError("Данные успешно сохранены !");
                            	if(!$database->updateRow("dicts",array("lchange"=>time()),array("id"=>$data['did'])))
								{
									$errors->appendJSError("Ошибка во время попытки обновления даты !");
									$errors->redirect("/server_.html");
								}else{
									$errors->redirect("/admin/languages/edit/".$data['did']);
								}
                            }
                        }
                    }
                break;
            }
        }else{
            $errors->appendJSError("Данный словарь не существует!");
        }
    }else{
        $errors->appendJSError("Неправильный идентификатор действия!");
    }
print $errors->outputData();
?>
