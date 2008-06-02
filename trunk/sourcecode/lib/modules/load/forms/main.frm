<?php
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
