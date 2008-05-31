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
?><div class='dT' style='width:100%;margin-left:0;'>
    <h2 class='title center'>Категории каталога</h2>
    <div class='header'>
        <div class='row'>
            <div class='col' style='width:6%;'>#</div>
            <div class='col' style='width:30%;'>Текст</div>
            <div class='col' style='width:10%;'>Позиция</div>
            <div class='col' style='width:30%;'>Родитель</div>
            <div class='col' style='width:20%;'>&nbsp;</div>
        </div>
    </div>
    <div class='body'>
        <?php
        $q=$database->proceedQuery("SELECT id,title,pos,pid
                                        FROM `#prefix#_cats`");
        if(!$database->isError())
        {
            if($database->getNumrows($q)!=0)
            {
                while($row=$database->fetchQuery($q))
                {
                   # print_r($row);
                   ?>
                   <div class='row'>
                        <div class='col' style='width:6%;'><?=$row['id'];?></div>
                        <div class='col' style='width:30%;'><?=rawurldecode($row['title']);?></div>
                        <div class='col' style='width:10%;'><?=$row['pos'];?></div>
                        <div class='col' style='width:30%;'><?=rawurldecode($database->getSQLParameter("cats","title",array("id"=>$row['pid'])));?></div>
                        <div class='col' style='width:20%;'>
                           <a href='/admin/cats/edit/<?=$row['id'];?>' title='Перейти к редактированию категории' style='font-size:10px;font-weight:bold;color:#FFAAAA;cursor:pointer;'>E</a>
						   <a href='/admin/cats/delete/<?=$row['id'];?>' title='Удалить категорию'>X</a>
                        </div>
                    </div>
                   <?php
                }
            }else{
            ?>
                <button onclick='Invis.core.loadPage("cats","add");return false;' style='width:100%;'>Добавить</button>
            <?php
            }
        }else{
            $errors->appendJSError("Ошибка во время диалога с БД!");
        }
        ?>
    </div>
</div>