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
include './lib/core/others/init.php';
$errorB=new Errors();
if(isset($_GET['s'])){
	switch($_GET['s']){
		case 'session':
			if(!isset($_GET['id'])){
				$errorB->appendJSError("Ошибка при проверке параметров !");
				$errorB->redirect("/");
			}else{
				if($sessions->isDeath($_GET['id'])){
					$errorB->appendJSError("Данные устарели, либо не существуют!");
					$errorB->redirect("/");
				}else{
					header("Content-Type:application/gzip");
					header('Content-Disposition:attachment; filename="key.gz";');
					print gzcompress($sessions->getData($_GET['id']));
					die();
				}
			}
			break;
	}
}
print $errorB->outputData();
?>
