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
function protocol_main($args)
{
	$system=&$GLOBALS['system'];
	$database=&$GLOBALS['database'];
	if(is_array($args))
	{
		if(trim($args['bindata'])=='' && trim($args['email']!=''))
		{
			if(false!==($file=$dirs->writeFile($system->getPath('files').'/temp/',$args['bindata']))){
				if(!$clients->registered())
				{
					$cid=$clients->register();
				}else{
					$cid=$clients->getClientID();
				}
				$oid=$database->insertRow("orders",array("",$cid,time(),'makets',0,$file,'open'));
				if(!$database->isError())
				{
					$system->sendNotification("new_order");
					$result['oid']=$oid;
					$result['cid']=$cid;
					$result['status']=200;
				}else{
					$result['status']=201;
					$result['error']='database error';
				}
			}else{
				$result['status']=201;
				$result['error']='uploading error';
			}
		}else{
			$result['status']=201;
			$result['error']='wrong parameters';
		}
	}else{
		$result['error']='wrong parameters';
		$result['status']=201;
	}
	return $result;
}

function xmlResponse($data)
{
	$result='<response>';
	if($data['status']!=200)
	{
		$result.="<error>".$data['errors']."</error>";
	}else{
		$result.="<response>";
		$result.="<client_id>".$cid."</client>";
		$result.="<order_id>".$oid."</order_id>";
		$result.="</response>";
	}
	$result.="</response>";
	return $result;
}
?>

?>
