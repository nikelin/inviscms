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
    class algorithm
	{
		public function quicksort($array)
		{
			$result=array();
			if(!is_array($array) || count($array)<2) return $array;
			$result=$this->unmerge_array($array[0],array_slice($array,1),$this->select("lx",$array[0],$array),$this->select("gx",$array[0],$array));
			$data=$lx.$array[0].$gx;
			return $result;
		}
		
		public function select($type,$x,$array)
		{
			$result=array();
			for($i=0;$i<count($array);$i++)
			{
				if($type=='lx' && $array[$i]<$x)
				{
					$result[]=$array[$i];
				}elseif($type=='gx' && $array[$i]>$x){
					$result[]=$array[$i];
				}
			}	
			return $result;
		}
		
		
		public function unmerge_array($x,$coda,$lx,$gx)
		{
			$result=array();
			for($i=0;$i<count($coda);$i++)
			{
				for($j=0;$j<count($lx);$j++)
				{
					$result=$this->unmerge_array($x,$code)
				}
			}
		}
		
		public function search(){}
	}
?>
