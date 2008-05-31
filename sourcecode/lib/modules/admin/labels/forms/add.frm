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
?><form action="" method="post">
	<div class="form">
		<div class='legend'>Добавление картинки в базу</div>
		<div class='row'>
		    <div class='label'>Введите название:</div>
		    <div class='value'>
			<input type='text' name='title'/>
		    </div>
		</div>
		<div class='row'>
		    <div class='label'>Выберите файл из базы:</div>
			<div class='value'>
			    <?php
			    $file=$tools->buildList("select","file",array("datasource"=>"files","label"=>"title","value"=>"id"));
			    if(!$file)
			    {
							?>
							<button onclick='Invis.core.loadPage("files","add");'>Загрузить файл</button>
							<?php
						}else{
							print $file;
						}
					?>
				</div>
		</div>
		<div class='row' id='cats' style='text-align:center;'>
			<?php
				$cats=$tools->buildList("select","cat",array("datasource"=>"cats","label"=>"title","value"=>"id"));
				if(!$cats)
				{
				
						?>
							<button onclick='Invis.core.loadPage("labels","cats",true);'>Добавить категорию</button>
						<?php
					}else
					{
					?>
						<div class='label'>Категория картинки:</div>
						<div class='value'><?=$cats;?></div>
					<?php
					}
				?>
			</div>
		<div class='row'>
			<div class='label submit'>
					<input type='submit' name='action_add' value='Добавить'/>
			</div>
		</div>
	</div>
</form>