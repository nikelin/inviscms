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
$config=simplexml_load_file('./config.xml');
if(!$config){
	die("Please as first start 'install.php' script !");
}else{
	$GLOBALS['path_to_site']=$config->param[0]['value'];
}
include "./lib/kernel/others/init.php";
$api->init();
header("Content-Type:application/xml;charset=".$api->getCharset());
print $api->waitForRequest();
?>