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
    $GLOBALS['skin_path']='./lib/skins/default';
	if($database->getSQLParameter("settings","site_closed",array("id"=>1))=="off"){
		header("Location: hello.html");
		exit;
	}
	$i18n->initializeDictionary($invisparser);
	#FIXME: add to `#prefix#_settings` table column `advertising_pages_list`, with list of pages to apply advertising wrappers
	#ADDITIONAL: needs to create system to set the wrappers to different user pages
	$tools->registerWrapper(unserialize($database->getSQLParameter("settings","advertising_pages_list")),array(array(&$sape_context,"replace_in_text_segment")));
	print $tools->postfetchProceed(stripslashes($invisparser->fetch(($GLOBALS['path_to_site']."/lib/skins/default/main.tpl"))));
?>