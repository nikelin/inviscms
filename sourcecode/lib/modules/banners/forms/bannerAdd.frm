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
?><form action='' method='post'>
	<div class='form'>
		  <div class='legend'>Добавление нового баннера</div>
	     <div class='row'>
		       <div class='label label1'>Клиент:</div>
		       <div class='value'>
               <?=$tools->buildList('select','cid',array('datasource'=>'clients','value'=>'id','label'=>'fio'));?>
					 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>Ссылка для баннера:</div>
		       <div class='value'>
					 			<input type='text' name='url'/>
				   </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>Ссылка на изображение:</div>
		       <div class='value'>
	             <input type='text' name='src' value='http://'/>
				 </div>
		  </div>
	     <div class='row'>
		       <div class='label label1'>...либо, выберите его из архива:</div>
		       <div class='value'>
		            <?=$tools->buildList("select","image",array("datasource"=>"files","value"=>"id","label"=>"title"));?>
				</div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>ALT-текст баннера:</div>
		       <div class='value'>
		            <input type='text' name='alt'/>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>Количество показов:</div>
		       <div class='value'>
		            <input type='text' name='views'/>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1' style='background-color:#3399ff;width:100%;text-align:center;'>HTML-код:</div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>
		            <textarea name='html' rows='5' style='width:100%;'></textarea>
			   </div>
		  </div>
		  <div class='row'>
		       <div class='label submit'>
						<button name='action_banneradd'>Загрузить</button>
				 </div>
		  </div>
	</div>
</form>
