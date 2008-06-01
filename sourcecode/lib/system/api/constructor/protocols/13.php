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
function protocol_main($args=array())
{
	$database=&$GLOBALS['database'];
	$where='';
	/**if(array_key_exists('t',$args)){
		$where.='AND #prefix#_templates.id='.$args['t'];
	}
	if(array_key_exists('c',$args)){
		$where.='LIMIT '.$args['c'];
	}**/
	#die_r($where);
	$q=$database->proceedQuery("SELECT #prefix#_templates.id AS tid,
										#prefix#_templates.price AS price,
										#prefix#_templates.type AS type,
										#prefix#_templates.title AS title,
										#prefix#_developers.title AS developer,
										#prefix#_texts.value AS category,
										#prefix#_files.src AS back_src,
										(SELECT src FROM `#prefix#_files` WHERE id=#prefix#_templates.front) AS front_src
										FROM `#prefix#_templates`, `#prefix#_texts`, `#prefix#_files`, `#prefix#_developers`
										WHERE 
											#prefix#_files.id=#prefix#_templates.back AND
											#prefix#_developers.id=#prefix#_templates.developer AND
											#prefix#_templates.status='on'
											".$where);
	if(!$database->isError())
	{
		$result=array();
		while($row=$database->fetchQuery($q))
		{
			$result[$row['tid']]=array();
			$result[$row['tid']]['type']=$row['type'];
			$result[$row['tid']]["title"]=$row['title'];
			$result[$row['tid']]["price"]=$row['price'];
			$result[$row['tid']]["category"]=$row['category'];
			$result[$row['tid']]["developer"]=$row['developer_name'];
			$result[$row['tid']]["back"]=$row['back_src'];
			$result[$row['tid']]["front"]=$row['front_src'];
		}
		
	}else{
		$result=DATABASE_PROCEED_ERROR;
	}
	return xmlResponse($result);
}

function xmlResponse($data)
{
	$result='<response>';
	if(!is_array($data))
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
			$result.="<front>".$v['front'].'</front>';
			$result.='</image>';
			$result.='</item>';
		}
	}
	$result.="</response>";
	return $result;
}
?>
