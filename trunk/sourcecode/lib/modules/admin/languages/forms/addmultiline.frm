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
?><form action='' method='post' enctype='multipart/form-data'>
    <div class='form'>
        <div class='legend'>Загрузка словаря</div>
        <div class='row'>
            <div class='label label1'>Выберите словарь:</div>
            <div class='value'>
                <?=$tools->buildList("select","dict",array("datasource"=>"dicts","label"=>"name","value"=>"id"));?>
            </div>
        </div>
        <div class='row'>
            <div class='label label1' style='width:100%;clear:both;text-align:center;'>
                Файл со словами:
            </div>
        </div>
        <div class='row'>
            <div class='label label1' style='width:100%;clear:both;'>
                <input type='file' name='data' style='width:100%;'/>
            </div>
        </div>
        <div class='row'>
            <div class='submit'>
                <input type='submit' name='action_addmultiline' value='Добавить'/>
            </div>
        </div>
    </div>
</form>