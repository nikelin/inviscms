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
?>    <form action='' method='post'>
        <div class='form' style='margin-top:20px;margin-bottom:20px;'>
            <div class='legend'>Редактирование блока</div>
            <div class='row'>
                <div class='label label1'>Сис. имя:</div>
                <div class='value'>
                    <input type='text' name='name'/>
                </div>
            </div>
            <div class='row'>
                <div class='label label1'>Заголовок:</div>
                <div class='value'>
                    <input type='text' name='title'/>
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
                    <input type='text' name='pos'/>
                </div>
            </div>
            <div class='row'>
                <div class='label label1' style='clear:both;width:100%;text-align:center;'>Код:</div>
            </div>
            <div class='row'>
                <div class='label' style='width:100%;clear:both'>
                    <textarea name='code' style='width:100%;height:150px;'></textarea>
                </div>
            </div>
            <div class='row'>
                <div class='submit'>
                    <input type='submit' name='action_add' style='width:100%;' value='Сохранить'/>
                </div>
            </div>
        </div>
    </form>