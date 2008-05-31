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
$id=$GLOBALS['params']['params'][2];
if(!is_numeric($id) || !$database->checkRowExists("dicts",array("id"=>$id))){
    $errors->appendJSError("Данный словарь не существует !");
}else{
?>
        <div class='dT' style='width:100%;margin-left:0%;'>
            <span class='header center'><h2>Просмотр словаря</h2></span>
            <?php
             $q=$database->getRows("texts","*",array("param"=>$id,"partition"=>"dicts"));
                if(!$database->isError($q)){
                ?>
                    <div class='header'>
                        <div class='row'>
                            <div class='col' style='width:5%;'>#</div>
                            <div class='col' style='width:30%;'>Идентификатор</div>
                            <div class='col' style='width:52%;'>Текст</div>
                            <div class='col' style='width:3%;'>&nbsp;</div>
                        </div>
                        <div class='row'>
                            <form action='' method='post'>
                                <input type='hidden' name='action' value='dict_title_change'/>
                                <input type='hidden' name='did' value='<?=$id;?>'/>
                                <div class='col' style='width:30%;'>
                                    Название словаря:
                                </div>
                                <div class='col' style='width:45%;'>
                                    <input type='text' name='name' value='<?=rawurldecode($database->getSQLParameter("dicts","name",array("id"=>$id)));?>' style='width:100%;'/>
                                </div>
                                <div class='col' style='width:20%;'>
                                    <button style='width:100%;' name='action_edit'>сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form action='' method='post'>
                    <input type='hidden' name='did' value='<?=$id;?>'/>
                    <input type='hidden' name='action' value='save'/>
                    <span class='header center'><h2>Лексическая база словаря</h2></span>
                    <div class='body'>
                        <?php
                            if($database->getNumrows($q)!=0)
                            {
                                while($row=$database->fetchQuery($q))
                                {
                                ?>
                                    <div class='row'>
                                        <div class='col' style='width:5%;background-color:#FF0052;'>
                                            <?=$row['id'];?><input type='hidden' name='id[]' value='<?=$row['id'];?>'/>
                                        </div>
                                        <div class='col' style='width:30%;'>
                                            <input type='text' name='name[]' style='width:100%;' value='<?=rawurldecode($row['name']);?>'/>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col' style='width:100%;clear:both;'>
                                            <textarea class='wymeditor' name='text[]' style='width:100%;'><?=htmlspecialchars(rawurldecode($row['value']));?></textarea>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col' style='width:3%;cursor:pointer;' onclick='Invis.core.loadPage("languages","deleteword/<?=$id;?>/<?=$row['id'];?>");return false;'>
                                            X
                                        </div>
                                        <div class='col' style='font-size:15px;font-weight:bold;color:#FF0000;width:3%;cursor:pointer;' onclick='Invis.core.loadPage("languages","addword");return false;'>
                                            +
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class='row'>
                                    <div class='col submit center' style='width:100%;clear:both;'>
                                        <button style='width:23%;' onclick='Invis.core.loadPage("languages","addword");return false;'>Добавить</button>
                                        <button style='width:23%;' name='action_edit'>Сохранить</button>
                                    </div>
                                </div>
                            <?php
                            }else{
                                ?>
                                <div class='row'>
                                    <div class='col submit center' style='width:100%;clear:both;'>
                                        <button onclick='Invis.core.loadPage("languages","addword");return false;'>Добавить элемент словаря</button>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                    </div>
                    </form>
                </div>
                <?php
                }else{
                    $errors->appendJSError("Ошибка во время диалога с БД!");
                    $errors->redirect("/server_.html");
                }
                ?>
    
<?php
    }
    print $errors->outputData();
?>