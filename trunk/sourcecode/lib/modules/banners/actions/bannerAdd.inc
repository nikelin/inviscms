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
  $errorB=new Errors();
  $data=$tools->getEnvVars('POST',true);
  if(!$tools->checkValues($data,array('url','cid')) && !is_numeric($data['views'])){
	$errorB->appendJSError('Ошибка во время проверки переданной информации !');
	$errorB->redirect('/admin/banners/banneradd');
  }else{
	      if(!$database->insertRow('banners',array('',$data['cid'],$data['url'],
		  											  $data['alt'],$data['image'],$data['src'],$data['html'],$data['views'],0,0,
													  time(),'off'))){
				  $errorB->appendJSError('Ошибка во время диалога с БД !');
				}else{
					$errorB->appendJSError('Баннер успешно сохранён!');
					$errorB->redirect('/admin/banners/banners');
				}
  }
print $errorB->outputData();
?>
