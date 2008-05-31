<?php
$error=new Errors();
$data=$tools->getEnvVars("POST",true);
if(!$tools->checkValues($data,array("id","count","size","format","type")))
{
	$check=$database->proceedQuery("SELECT id FROM `#prefix#_catalog` WHERE LEFT(MD5(id),6)='".$params[1]."'");
	if(!$database->isError()){
		if($database->getNumrows($check)!=0){
			if(!$basket->add($data['id'],1,$data['type'],$data['size'],$data['format'])){
				$error->appendJSError("{^order_proceed_error^}!");
				$error->redirect("server_.html");
			}else{
				$error->appendJSError("{^order_proceed_successful^}!");
				$error->redirect("/basket/view");
			}
		}else{
			$error->appendJSError("{^product_ne^}!");
			$error->redirect("error404.html");
		}
	}else{
		$error->appendJSError("{^db_error^}!");
		$error->redirect("server_.html");
	}
}else
{
	$error->appendJSError("Ошибка во время проверки параметров !");
}
print $errors->outputData();
?>