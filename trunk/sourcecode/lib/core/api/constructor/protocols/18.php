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
	$database=&$GLOBALS['database'];
	if(is_array($args))
	{
		$result=array();
		$lc=explode(";",$args['lti']);
		if(count($lc)<=1)
		{
			$result=API_WRONG_DATA;
		}else{
			$label=array();
			for($i=0;$i<count($lc);$i++)
			{
				$lp=explode(",",$lc[$i]);
				$label[]=array("place"=>$lp[0],"coords"=>$lp[1],"d"=>$lp[2]);
			}
			$result["fti"]=$args['fti'];
			$result["label"]=$label;
			$result["email"]=$args['email'];
			$result["price"]=$args['price'];
			$result['client']=$clients->getClientID();
			if(false===($oid=$database->insertRow("orders",array("",$clients->getClientID(),time(),'orders',$args['price'],$jsonencoder->encode($label),'open'))))
			{
				$result=DABASE_PROCEED_ERROR;
			}else{
				$result['id']=$oid;
			}
		}
	}else{
		$result=API_WRONG_PARAMS;
	}
	return $result;
}

function xmlResponse($data)
{
	$result='<response>';
	if(is_string($data))
	{
		$result.="<error>".$data."</error>";
	}else{
		$rid='<id>'.$result['oid'].'</id>';
	}
	$result.="</response>";
	return $result;
}
?>
