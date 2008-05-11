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
 function die_r($text){
	if(is_object($text) || is_array($text)){
		print htmlspecialchars(print_r($text,true));
	}else{
		print htmlspecialchars($text);
	}
	exit;
 }
 
 function wasIncluded($file){
	$incl=false;
	$file=str_replace('/','\\',$file);
 	foreach(get_included_files() as $k=>$v){
	  if($v==$file){
		 $incl=true;
		 break;
	  }
	}
	return $incl;
 }
 
 function die_br($text){
	return "<br/>".die_r($text);
 }
 
 
 function print_rbr($text){
	if(is_array($text) || is_object($text)){
     	print_r($text,true).'<br/>';
	}else{
	  print($text)."<br/>";
	}
 }
?>
