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
    <div class='form' style='margin-top:45px;margin-bottom:60px;'>
        <div class='legend'>
            Добавление новой товарной позиции
        </div>
        <div id='body' style='text-align:center;'>
            <button style='width:100%;' onclick='Invis.tools.changeElVis("mainInfo","switch");return false;'>
                Общаяя инф-ция
            </button>
            <div id='mainInfo' style='display:none;text-align:left;'>
                <div class='row'>
                    <div class='label label1'>
                        Название товара
                    </div>
                    <div class='value value1'>
                        <input type='text' name='title'/>
                    </div>
                </div>
                <div class='row'>
                    <div class='label label1'>
                        Категория
                    </div>
                    <div class='value value1'>
                        <?=$tools->buildList("select","cat",array("datasource"=>"cats","label"=>"title","value"=>"id"));?>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='label label1' style='background-color:#ffcc66;text-align:center;width:100%;clear:both;'>
                    <span>Описание товара</span>
                </div>
            </div>
            <div class='row'>
                <div class='label label1' style='height:135px;text-align:center;width:100%;clear:both;'>
                    <textarea name='description' rows='6' cols='45'>
                    </textarea>
                </div>
            </div>
            <div class='row'>
                <div class='label label1' style='background-color:#ffcc66;'>
                    Теги (ключевые слова):
                </div>
                <div class='value value1'>
                    <input type='text' name='tags'/>
                </div>
            </div>
        </div>
        <button style='width:100%;' onclick='Invis.tools.changeElVis("templates","switch");return false;'>
            Настройка изображения товара
        </button>
        <div id='configTemplate' style='display:none;text-align:left;'>
            <button style='display:block;' onclick='Invis.tools.changeElVis("configTemplate","off");Invis.tools.changeElVis("templates","on");return false;'>
                Выбрать другой
            </button>
            <div style='clear:both;'>
                <img src='preview.php' id='templateSx' style='float:left;background-image:none;display:block;width:450px;height:500px;background-color:#000000;color:#F2FFFF;border:1px #FFFFFF dotted;'/>
            </div>
            <div>
                <span style='font-weight:bold;text-align:center;display:block;'>Центрирование картинки:</span>
                <div style='margin-left:25%;'>
                    <input type='hidden' name='parm1' id='parm1' value='100'/><input type='hidden' name='parm2' id='parm2' value='100'/><input type='hidden' name='parm3' id='parm3' value='100'/><input type='hidden' name='parm4' id='parm4' value='100'/><input type='hidden' name='parm5' id='parm5' value='1'/><input type='hidden' name='parm6' id='parm6' value='1'/><span style='display:block;'><span style='margin-right:90px;width:70px;'>X:</span>
                        <button style='width:40px;' onclick='Invis.tools.moveLabel("plus","x");return false;'>
                            +
                        </button>
                        <button style='width:40px;' onclick='Invis.tools.moveLabel("minus","x");return false;'>
                            -
                        </button>
                    </span>
                    <span style='display:block;'><span style='margin-right:90px;width:70px;'>Y:</span>
                        <button style='width:40px;' onclick='Invis.tools.moveLabel("plus","y");return false;'>
                            +
                        </button>
                        <button style='width:40px;' onclick='Invis.tools.moveLabel("minus","y");return false;'>
                            -
                        </button>
                    </span>
                    <span style='display:block;'><span style='margin-right:50px;width:70px;'>Ширина:</span>
                        <button style='width:40px;' onclick='Invis.tools.resizeLabel("plus","width");return false;'>
                            +
                        </button>
                        <button style='width:40px;' onclick='Invis.tools.resizeLabel("minus","width");return false;'>
                            -
                        </button>
                    </span>
                    <span style='display:block;'><span style='margin-right:60px;width:70px;'>Длина:</span>
                        <button style='width:40px;' onclick='Invis.tools.resizeLabel("plus","height");return false;'>
                            +
                        </button>
                        <button style='width:40px;' onclick='Invis.tools.resizeLabel("minus","height");return false;'>
                            -
                        </button>
                    </span>
                </div>
            </div>
            <h3>Картинка для наложения:</h3>
            <div>
                <?php
								$q=$database->proceedQuery("SELECT *, (SELECT src FROM `#prefix#_files` WHERE id=fid) AS src FROM `#prefix#_labels` WHERE status='on'");
								$num=0;
								if($database->getNumrows($q)!=0){
								 ?>
					                <span style='display:block;margin-left:50px;'>
					                <?php
                                     while($row=$database->fetchQuery($q)){
									    ($num!=0 && $num%3==0)?print('</span><span style="clear:both;display:block;margin-left:50px;">'):'';
									    ?>
                						<img onclick='Invis.tools.applyLabel(this.id)' id='<?=$row['id'];?>' src='<?=($row['src'][0]=='.')?substr($row['src'],1):$row['src'];?>' style='margin-left:10px;float:left;width:80px;height:80px;border:1px #000000 dotted;cursor:pointer;'/>
               							 <?php
									   		 $num++;
										}
										}else{
                                                                ?>
                <div class='center' style='background-color:#CCCCCC;'>
                    <button onclick='Invis.core.loadPage("labels","add");return false;'>
                        Добавить картинку
                    </button>
                </div>
                <?php
								}
								?>
            </div>
        </div>
        <div id='templates' style='display:none;'>
            <div class='row'>
                <div class='label' style='background-color:#FFFFEE;text-align:center;width:100%;clear:both;'>
                    Доступные шаблоны
                </div>
                <div id='templatesList' style='display:block;'>
                    <?php
					    $q=$database->proceedQuery("SELECT *, 
													(SELECT src FROM `#prefix#_files` WHERE id=front) AS src
													 FROM  `#prefix#_templates` WHERE status='on'");
					    if($database->getNumrows($q)==0){
                                            ?>
                    <div class='center' style='background-color:#CCCCCC;'>
                        <button onclick='Invis.core.loadPage("templates","add");return false;'>
                            Добавить шаблон
                        </button>
                    </div>
                    <?php
					    }else{
					    ?>
                    <span style='display:block;margin-left:50px;'>
                        <?php
						$num=0;
						while($row=$database->fetchQuery($q)){
                                                    ($num!=0 && $num%4==0)?print('</span><span style="clear:both;display:block;margin-left:50px;">'):'';
                                                    ?>
                        <img onclick='Invis.tools.selectTemplate(this.id)' id='<?=$row['id'];?>' src='<?=($row['src'][0]=='.')?substr($row['src'],1):$row['src'];?>' class='templ_icon01'/>
                        <?php
						    $num++;
						}
                                                ?>
                    </span>
                    <?php
					    }
                                            ?>
                </div>
            </div>
        </div>
        <button style='width:100%;' onclick='Invis.tools.changeElVis("priceSettings","switch");return false;'>
            Настройки цены
        </button>
        <div id='priceSettings' style='display:none;'>
            <div class='row'>
                <div class='label' style='background-color:#ffcc66;'>
                    Цена товарной позиции:
                </div>
                <div class='value'>
                    <input type='text' name='price'/>
                </div>
            </div>
	    <div class='row'>
                <div class='label' style='background-color:#ffcc66;'>
                    Скидка (%):
                </div>
                <div class='value'>
                    <input type='text' name='discount'/>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='label submit'>
                <input type='submit' name='action_add' value='Добавить в каталог'/>
            </div>
        </div>
    </div>
    </div>