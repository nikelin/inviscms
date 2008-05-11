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
?><div style='clear:both;'>
	<?php
	$params=$GLOBALS['params']['params'];
	print $uinterface->getCatalogPath($params[0],true);
		$data=$uinterface->showCategoriesLinks(isset($params[0])?$params[0]:0);
	  	print $data['to_display'];
		$cats=$data['cats'];
		foreach($cats as $k=>$v){
			   print $uinterface->goods_list($v);
		}
	
			    
	?>
	<div style='clear:both;width;100%;display:block;'>
		<?=$uinterface->goods_list(null,array('discount!'=>0),null,3);?>
	</div>
</div>