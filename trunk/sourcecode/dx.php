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
 include $GLOBALS['path_to_site']."/lib/core/others/init.php";
if(isset($_GET['x']))
{
	switch($_GET['x']){
		case '0x173':
			$d=array();
			$d['message']='empty';
			$d['status']=0;
			//Check parameter value
			if(isset($_GET['id']))
			{
				if($database->checkRowExists('catalog',array("LEFT(MD5(id),6)"=>$_GET['id'])))
				{
					$q=$database->proceedQuery("DELETE FROM `#prefix#_catalog` WHERE LEFT(MD5(id),6)=".$_GET['id']);
					if(!$database->isError())
					{
						$d['status']=200;
						$d['message']='Элемент корзины успешно удалён!';
					}else
					{
						$d['message']='Ошибка во время удаления!';
						$d['status']=500;
					}
				}else
				{
					$d['message']='Вы не добавляли данный товар в свою корзину!';
				}
			}else
			{
				$d['message']='Ошибка во время обращения к протоколу!';
				$d['status']=500;
			}
			print $jsonencoder->encode($d);
			break;
	}
}
?>