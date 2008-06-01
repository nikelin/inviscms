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
		$q=$database->proceedQuery("SELECT back,front,
									(SELECT src FROM `#prefix#_files` WHERE id=back) AS back_src,
									(SELECT src FROM `#prefix#_files` WHERE id=front) AS front_src
									FROM `#prefix#_templates`
									WHERE status='on' AND id='".mysql_real_escape_string($args['id']));									
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				$data=$database->fetchQuery($q);
				$result=array();
				$result['back_src']=$data['back_src'];
				$result['front_src']=$data['front_src'];
			}else{
				$result=API_TEMPLATE_NE;
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
		$rid='<image>';
		$rid='<back>'.$result['back_src'].'</back>';
		$rid='<front>'.$result['front_src'].'</front>';
		$rid='</image>';
	}
	$result.="</response>";
	return $result;
}
?>
