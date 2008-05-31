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
		$q=$database->proceedQuery("SELECT fid
									(SELECT src FROM `#prefix#_files` WHERE id=fid) AS src
									FROM `#prefix#_labels`
									WHERE status='on' AND id='".mysql_real_escape_string($args['id']));									
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				$data=$database->fetchQuery($q);
				$result=array();
				$result['back_src']=$data['labels'];
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
		$rid='<image src="'.$result['back_src'].'"/>';
	}
	$result.="</response>";
	return $result;
}
?>
