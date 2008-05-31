<?php
$error=new Errors();
$id=$GLOBALS['params']['params'][1];
	$check=$database->proceedQuery("SELECT id FROM `#prefix#_catalog` WHERE LEFT(MD5(id),6)='".$id."'");
	if(!$database->isError()){
		if($database->getNumrows($check)!=0){
			if(!$basket->add($id,1,'male','M','A4')){
				$error->appendJSError("{^order_proceed_error^}!");
				$error->redirect("server_.html");
			}else{
				$error->appendJSError("{^order_proceed_successful^}!");
				$error->redirect("/");
			}
		}else{
			$error->appendJSError("{^product_ne^}!");
			$error->redirect("error404.html");
		}
	}else{
		$error->appendJSError("{^db_error^}!");
		$error->redirect("server_.html");
	}
print $error->outputData();
?>