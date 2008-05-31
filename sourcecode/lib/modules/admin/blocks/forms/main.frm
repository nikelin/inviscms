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
?><div class='dT'>
    <div class='header'>
        <div class='row'>
            <div class='col'>
                Сис. имя
            </div>
            <div class='col'>
                Заголовок
            </div>
            <div class='col'>
                Размещение
            </div>
            <div class='col'>
                Позиция
            </div>
            <div class='col'>
                &nbsp;
            </div>
        </div>
    </div>
    <div class='body'>
        <?php
        $q=$database->getRows("blocks","*");
        if($database->getNumrows($q)!=0)
        {
            while($row=$database->fetchQuery($q))
            {
            ?>
                <div class='row'>
                    <div class='col'><?=rawurldecode($row['name']);?></div>
                    <div class='col'><?=rawurldecode($row['title']);?></div>
                    <div class='col'><?=$row['place'];?></div>
                    <div class='col'><?=$row['pos'];?></div>
                    <div class='col'>
                        <button onclick='Invis.core.loadPage("blocks","edit/<?=$row['id'];?>");return false;' style='width:25%;'>E</button>
                        <button onclick='Invis.core.loadPage("blocks","changestatus/deny/<?=$row['id'];?>");return false;' style='width:25%;'>D</button>
                        <button onclick='Invis.core.loadPage("blocks","changestatus/restore/<?=$row['id'];?>");return false;' style='width:25%;'>R</button>
                    </div>
                </div>
            <?php
            }
        }else{
            ?>
            <div class='row'>Блоки не найдены !</div>
            <?
        }
        ?>
    </div>
</div>
