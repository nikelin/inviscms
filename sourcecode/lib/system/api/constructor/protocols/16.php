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
<?php
function protocol_main($args)
{
	$database=&$GLOBALS['database'];
	if(is_array($args))
	{
		$where=array();
		$q=$database->proceedQuery("SELECT id AS tid,developer,type,title,
									(SELECT title FROM `#prefix#_developers` WHERE id=developer) AS developer_name;
									(SELECT value FROM `#prefix#_texts` WHERE id=cid) AS category,
									(SELECT src FROM `#prefix#_files` WHERE id=back) AS back_src,
									(SELECT src FROM `#prefix#_files` WHERE id=front) AS front_src
									
									FROM `#prefix#_templates`
									WHERE status='on' AND id=".$args['id']);
		if(!$database->isError())
		{
			$result=array();
			$row=$database->fetchQuery($q));
			$result[$row['tid']]=array();
			$result[$row['tid']]["title"]=$row['title'];
			$result[$row['tid']]["price"]=$row['price'];
			$result[$row['tid']]["category"]=$row['category'];
			$result[$row['tid']]["developer"]=$row['developer_name'];
			$result[$row['tid']]["back"]=$row['back_src'];
			$result[$row['tid']]["front"]=$row['front_src'];
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
			$result.="<price>".$v['price'].'</price>';
			$result.="<developer>".$v['developer'].'</developer>';
			$result.="<category>".$v['category'].'</category>';
			$result.="<image>";
			$result.="<back>".$v['back'].'</back>';
			$result.="<front>".$data[$i]['front'].'</front>';
			$result.='</image>';
			$result.='</item>';
		}
	}
	$result.="</response>";
	return $result;
}
?>

?>
