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
?><form action='' method='post' enctype="multipart/form-data">
<h2 class='title center' title='Загрузка макета футболки'>Отправка макета</h2>
<div>
	<h3 onclick='Invis.tools.changeElVis("more","switch")' style='cursor:pointer;background-color:#EEEEFE;color:inherit;text-align:left;'>
		+  Требования к макету (нажми для подробностей)
	</h3>
	<blockquote id='more' style='display:none;text-align:left;'>
		<p>Формат макета: <strong>TIFF</strong>, <strong>EPS</strong>, <strong>PDF</strong>, <strong>JPEG</strong>, <storng>AI</storng>, <strong>CDR</strong>.</p>
		<p>Для растровых форматов разрешение 1:1 ---<strong>300dpi</strong>
		<p/>
		<p>Цветовая модель: <strong>CMYK</strong>, <strong>RGB</strong></p>
		<blockquote>
			<em>Файлы, изготовленные в других форматах, не соответствующие требованиям к макету, не принимаются!</em> 
		</blockquote>
		<h3 style='cursor:pointer;background-color:#EEEEFE;color:inherit;text-align:left;'>
			Таблица соответствия
		</h3>
		
		<p>
		Оптимальный размер файлов для печати на футболках: 
		<ul>
		    <li>А6 = 9x13cm 300dpi = 1063x1535</li> 
		    <li>А5 = 13x19cm 300dpi = 1535x2244</li>
		    <li>А4 = 19x28cm 300dpi = 2244x3307</li> 
		</ul>
		</p>
		<p>Минимальный размер файлов для печати на футболках: </p>
		<ul>
		   <li>А6 = 9x13cm 150dpi = 531x768 </li>
		   <li>А5 = 13x19cm 150dpi = 768x1122 </li>
		   <li>А4 = 19x28cm 150dpi = 1122x1654 </li>
		</ul>
		<p> 
		Вектор: формат файла <strong>.eps</strong>, <strong>.aі (v.10)</strong>, <strong>.cdr (v.10)</strong>. Шрифты должны быть переведены в кривые. 
		</p>
		Мы обязуемся не использовать присланные Вами фотографии и картинки в своих корыстных целях без Вашего согласия. 
		</blockquote>
			<div class='uform' style='font-size:15px;width:85%;margin-left:5%;'>
				<div class='legend'>Форма отправки данных</div>
				<div class='row'>
					<div class='label'>Ваше имя: (+)</div>
					<div class='value'>
						<input type='text' name='name' style='width:100%;'/>
					</div>
				</div>
				<div class='row'>
					<div class='label'>Ваш e-mail либо телефон: (+)</div>
					<div class='value'>
						<input type='text' name='contacts' style='height:100%;width:100%;'/>
					</div>
				</div>
				<div class='row'>
					<div class='label' style='height:100%;background-color:#000000;color:#FFFFFF;font-weight:bold;width:100%;clear:both;text-align:center;'>Информация для нашего менеджера:</div>
				</div>
				<div class='row'>
					<div class='value' style='width:100%;clear:both;'>
						<textarea id='description' name='description' style='width:100%;height:100px;'></textarea>
					</div>
				</div>
				<div class='row' >
					<div class='label' style='width:100%;clear:both;text-align:center;'>
						<strong>
							Макет (желательно сжатый в *.ZIP либо в архиве другого формата):
						</strong>
					</div>
				</div>
				<div class='row'>	
					<div class='label' style='width:100%;clear:both;text-align:center;'>
						<input type='file' name='maket'/>
					</div>
				</div>
				<div class='submit'>	
					<input type='submit' style='font-weight:bold;height:30px;width:100%;' name='action_main' value='Отправить'/>
				</div>
			</div>
		</div>
		</form>
