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
#$this->prepareMultilingual(array("string_0f4dca"=>"dasd","string_0a4dfa"=>"dasdasdsfx"));
$curr_sets=$database->getRows("settings","*");
$curr_sets=$database->fetchQuery($curr_sets);
$frm=new forms();
$frm->init("POST","");
$frm->addLegend("Изменение настроек сайта");
$langs=$i18n->getLangs();
$frm->addInput("text","mainpath",$frm->addField("Путь к исполняемым файлам:","pair"),"","",$curr_sets['main_path']);
$skins=$dirs->getContents("./lib/skins","dir");
$s2="<select name='siteskin'>";
foreach($skins as $k=>$v)
{
	$s2.="<option value='".$v."' ".(($curr_sets['site_skin']==$v)?"selected":"").">".$v."</option>";
}
$s2.="</select>";
$frm->addField("Тема сайта","pair",$s2);
for($i=0;$i<count($langs);$i++)
{
	$frm->addInput("text","sitetitle_lng_".substr(md5($langs[$i]['id']),0,6),$frm->addField("Слоган сайта (язык:<span style='color:#FF0000;'>".rawurldecode($langs[$i]['name']).")</span>:","pair"),"","",$i18n->lngParse($curr_sets['site_title'],$langs[$i]['id']));
}
for($i=0;$i<count($langs);$i++)
{
	$frm->addInput("text","sitedescription_lng_".substr(md5($langs[$i]['id']),0,6),$frm->addField("Текст описания сайта (язык:<span style='color:#FF0000;'>".rawurldecode($langs[$i]['name']).")</span>:","pair"),"","",$i18n->lngParse($curr_sets['site_description'],$langs[$i]['id']));
}
for($i=0;$i<count($langs);$i++)
{
	$frm->addInput("text","sitekeywords_lng_".substr(md5($langs[$i]['id']),0,6),$frm->addField("Ключевые слова через `,` (язык :<span style='color:#FF0000;'>".rawurldecode($langs[$i]['name'])."</span>):","pair"),"","",$i18n->lngParse($curr_sets['site_keywords'],$langs[$i]['id']));
}
$frm->addField("Язык сайта:","pair",$tools->buildList("select","lang",array("datasource"=>"dicts","value"=>"id","label"=>"name"),array("value"=>$curr_sets['lang'])));
$frm->addInput("text","replyto",$frm->addField("Контактный e-mail:","pair"),"","",$curr_sets['reply_to']);
$frm->addInput("text","defaultcharset",$frm->addField("Кодировка по-умолчанию:","pair"),"","",$curr_sets['default_charset']);
$frm->addInput("text","icq",$frm->addField("Номер ICQ:","pair"),"","",$curr_sets['icq']);
$frm->addInput("text","telephone",$frm->addField("Телефонный номер:","pair"),"","",$curr_sets['telephone']);
$frm->addInput("text","email",$frm->addField("E-mail адрес:","pair"),"","",$curr_sets['email']);
$frm->addInput("text","logo",$frm->addField("Введите адрес логотипа:","pair"),"","",$curr_sets['logotype']);
$frm->addInput("text","paykey",$frm->addField("Ключ шифрования платёжной информации:","pair"));
$frm->addInput("checkbox","leftpanel",$frm->addField("Показывать левую панель (".$database->getSQLParameter("settings","leftpanel")."):","pair"));
$frm->addInput("checkbox","rightpanel",$frm->addField("Показывать правую панель: (".$database->getSQLParameter("settings","rightpanel").")","pair"));
$frm->addInput("checkbox","siteclosed",$frm->addField("Статус сайта: ","pair"),"",($curr_sets['site_closed']=='on')?array("checked"=>'checked'):'');
$frm->addSubmit("action_main","Сохранить");
print $frm->render(true);
?>