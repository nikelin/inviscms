<?php
include "../lib/core/others/init.php";
$errors=new Errors();
$history=new history();
if($sessions->isDeath("stage")) 
	$sessions->registerData("stage",1);
$curr_stage=$sessions->getData("stage");
if($curr_stage==1)
{
	$history->append_event(new log_event("installation process inited","notice"));
}
$xsl=new xslt();
if(!@inclide("./stages/".$stage))
{
	$history->append_event(new log_event("go to stage #".$stage));
}
?>