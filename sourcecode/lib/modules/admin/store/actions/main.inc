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
$data=$tools->getEnvVars("POST",true);
$error=new Errors();
if($tools->checkValues($data,array("tid","lid","title","price","description","pid")))
{
    if(!is_numeric($pid) || !$database->checkRowExists("catalog",array("id"=>$data['pid'])))
    {
	$error->appendJSError("������ ����� �� ����������!");
    }else
    {
	if($database->updateRow("catalog",array("tid"=>$data['tid'],
						"lid"=>$data['lid'],
						"title"=>$data['title'],
						"description"=>$data['description'],
						"price"=>$data['price'],
						"discount"=>$data['discount'],
						"tags"=>$data['tags'],
						"cid"=>$data['cid'],
						"status"=>($data['active'])?'on':'off'),array("id"=>$data['pid'])))
	{
	    $error->appendJSError("���������� ������� ���������!");
	}else{
	    $error->appendJSError("������ �� ����� ������� � ��!");
	}
    }
}
print $error->outputData();
?>