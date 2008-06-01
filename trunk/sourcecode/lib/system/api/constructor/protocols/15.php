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
		$where=array();
		if(array_key_exists('t',$args)){
			$where['type']=$args['t'];
		}
		if(array_key_exists('c',$args)){
			$where['cid']=$args['c'];
		}	
		$limit=(array_key_exists('n',$args))?"LIMIT 0,".$args[n]:"";
			
		$q=$database->getRows("sizes",array("id","name","value"),"",$limit);
		if(!$database->isError())
		{
			$result=array();
			while($row=$database->fetchQuery($q))
			{
				$result[$row['id']]=array();
				$result[$row['id']]["title"]=$row['title'];
				$result[$row['id']]["value"]=$row['value'];
			}	
		}else{
			$result=DATABASE_PROCEED_ERROR;
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
		foreach($data as $k=>$v)
		{
			$result.='<item>';
			$result.="<title>".$v['name']."</title>";
			$result.="<value>".$v['value']."</value>";
			$result.='</item>';
		}
	}
	$result.="</response>";
	return $result;
}
?>
