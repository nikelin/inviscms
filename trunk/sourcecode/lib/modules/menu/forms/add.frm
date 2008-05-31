<?php
$frmB=new forms();
$frmB->init("POST","");
$frmB->addLegend("Создание элемента меню");
$frmB->addInput("text","title",$frmB->addField("Введите надпись элемента:","pair"));
$frmB->addInput("text","link",$frmB->addField("Ссылка:","pair"));
$frmB->addInput("select","place",$frmB->addField("Размещение на странице:","pair"),"","",array("horizontal_top"=>"Верхнее горизонтальное","horizontal_bottom"=>"Нижнее горизонтальное"));
$frmB->addInput("text","alt",$frmB->addField("ALT-текст ссылки:","pair"));
$lang=$tools->buildList("select","lang",array("datasource"=>"dicts","value"=>"id","label"=>"title"));
$lang=($lang)?$lang:"<button onclick='Invis.core.loadPage(\"languages\",\"add\");return false;'>Добавить</button>";
$frmB->addField("Выберите язык элемента:","pair",$lang);
$frmB->addInput("select","target",$frmB->addField("Способ открытия:","pair"),"","",array("_blank"=>"В новом окне","_both"=>"В том же окне"));
$frmB->addSubmit("action_add","Добавить",array("style"=>"width:100%;"));
print $frmB->render(true);
?>