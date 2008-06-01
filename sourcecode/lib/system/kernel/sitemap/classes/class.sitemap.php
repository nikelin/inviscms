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
class sitemap
{
	public function add_url($url,$last_mod,$priority){}
	/**
	 * 
	 * @return 
	 * @param $source Object
	 * @param $url_format Object
	 * @param $priority Object
	 * @param $last_mod Object
	 * 
	 * Example:
	 * 
	 * 		sitemap::aggregate("pages","{host}/[$ufo]",tools::getPagePriority(),"[$pub_date]");
	 * 
	 */
	public function aggregate($source,$url_format,$priority,$last_mod,$where=1)
	{
		$result=null;
		$database=&$GLOBALS['database'];
		$where=$database->makeWhereString($where);
		$resul
		if($database->_tableExists($source))
		{
			$q=$database->proceedQuery("SELECT * FROM `#prefix#_".$source."` ".$where);
			if(!$database->isError())
			{
				if($database->getNumrows($q)!=0)
				{
					while($row=$database->fetchQuery($q))
					{
						$result.
					}
				}
			}else
			{
				
			}
		}
	}
}
