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
$params=$GLOBALS['params'];
print $uinterface->getCatalogPath(0,false);
	$data=$uinterface->showCategoriesLinks();	
	print $data['to_display'];	    
?>
<h2 class='title' title='Новые поступления в магазин' style='clear:both;margin:0;padding:0;padding-top:5px;font-size:30px;font-family:Helvetica,"Times New Roman"'><span style='color:#0000FF;font-weight:bold;'><u>Н</u></span>ов<span style='color:#FF33CC'>и</span>н<span style='color:#FF0000;'><strong>к</strong></span>и!</h2>
<?php
print $uinterface->goods_list(null,null,array("date","ASC"),3);
?>
<h2  title='Наболее покупаемые и востребованые футболки в ФутболкаPrint&amp;copy;' style='clear:both;margin:0;padding:0;padding-top:5px;font-size:30px;font-family:Helvetica,"Times New Roman"'><span style='color:#6699CC;'>П</span>оп<span style='color:#33CCCC;'>у</span>ля<span style='color:#99CC33;'>р</span>ные!</h2>
<?php
print $uinterface->goods_list(null,null,array("date","ASC"),3);
$data=$uinterface->goods_list(null,array('discount!'=>0),null,3);
#die_r($data);
if(trim(strip_tags($data,"img"))!='')
{
?>
<h2  title='Наболее покупаемые и востребованые футболки в ФутболкаPrint&amp;copy;' style='clear:both;margin:0;padding:0;padding-top:5px;font-size:30px;font-family:Helvetica,"Times New Roman"'><span style='color:#FF0000;'>А</span>кци<span style='color:#0033FF;'>я</span>!</h2>
<?php
print $data;
}
?>