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
			
		$q=$database->proceedQuery("SELECT id AS lid,title,
									(SELECT value FROM `#prefix#_texts` WHERE partition='labels' AND id=cid) as category,
									(SELECT src FROM `#prefix#_files` WHERE id=fid) AS image
									FROM `#prefix#_labels` 
									WHERE status='on' ".$limit);
		if(!$database->isError())
		{
			$result=array();
			while($row=$database->fetchQuery($q))
			{
				$result[$row['lid']]=array();
				$result[$row['lid']]["title"]=$row['title'];
				$result[$row['lid']]["category"]=$row['category'];
				$result[$row['lid']]["image"]=$row['image'];
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
			$result.='<item id="'.$k.'">';
			$result.="<title>".$v['title'].'</title>';
			$result.="<category>".$v['category'].'</category>';
			$result.="<image>";
			$result.=$data[$i]['image'];
			$result.='</image>';
			$result.='</item>';
		}
	}
	$result.="</response>";
	return $result;
}
?>
