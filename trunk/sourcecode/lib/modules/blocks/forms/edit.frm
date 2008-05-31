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
$id=isset($GLOBALS['params']['params'][2])?$GLOBALS['params']['params'][2]:die("Неверный параметр передан");
$error=new Errors();
if(is_numeric($id) && $id>=0){
  if($database->checkRowExists("blocks",array("id"=>$id))){
    $q=$database->getRows("blocks","*",array("id"=>$id));
    $data=$database->fetchQuery($q);
    ?>
    <form action='' method='post'>
        <div class='form' style='margin-top:20px;margin-bottom:20px;'>
            <div class='legend'>Редактирование блока</div>
            <div class='row'>
                <div class='label label1'>Сис. имя:</div>
                <div class='value'>
                    <input type='text' name='name' value='<?=rawurldecode($data['name']);?>'/>
                </div>
            </div>
            <div class='row'>
                <div class='label label1'>Заголовок:</div>
                <div class='value'>
                    <input type='text' name='title' value='<?=rawurldecode($data['title']);?>'/>
                </div>
            </div>
            <div class='row'>
                <div class='label label1'>Размещение:</div>
                <div class='value'>
                    <select name='place'>
                        <option value='left'>Левая панель</option>
                        <option value='right'>Правая панель</option>
                    </select>
                </div>
            </div>
            <div class='row'>
                <div class='label label1'>Позиция:</div>
                <div class='value'>
                    <input type='text' name='pos' value='<?=rawurldecode($data['pos']);?>'/>
                </div>
            </div>
            <div class='row'>
                <div class='label label1' style='clear:both;width:100%;text-align:center;'>Код:</div>
            </div>
            <div class='row'>
                <div class='label' style='width:100%;clear:both;height:60px;'>
                    <textarea name='code' style='height:50px;width:100%;'><?=stripslashes(rawurldecode($data['content']));?></textarea>
                </div>
            </div>
            <div class='row'>
                <div class='submit'>
                    <input type='hidden' name='bid' value='<?=$id;?>'/>
                    <input type='submit' name='action_edit' style='width:100%;' value='Сохранить изменения'/>
                </div>
            </div>
        </div>
    </form>
    <?php
  }else{
    $error->appendJSError("Данный блок не существует!");
  }
}else{
    $error->appendJSError("Передан неверный параметр!");
}
print $error->outputData();
?>