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
	$paths=array(
			"uforms"=>$GLOBALS['path_to_site'].'/lib/skins/default/uforms',
			"jallib"=>$GLOBALS['path_to_site'].'/lib/gt/jallib'
			);
	$form=$GLOBALS['params']['params'][0];
   if(trim($form)!=''){
				$f=$paths['uforms'].'/'.$form.'.tpl';
				if(file_exists($f)){
					print htmlspecialchars(eval('?>'.join('',file($f))));
				}else{
					print ("Internal script error !");
				}
			}
?>
