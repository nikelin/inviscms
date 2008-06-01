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
class ini{
    /**
	 * Automate to provide INI-files parsing
	 *
	 * @param unknown_type $path
	 */
	public function iniParse($path){
		$sets=array();
		if(file_exists($path)){
			$data=join('',@file($path));
			if(trim($data)!=""){
				$i=0;
				$state="none";
				$continue=0;
				$blocks=array();
				$lb="";
				$lv="";
				$end=0;
				while($i<(strlen($data)-1)){
					$d=(isset($data[$i]))?$data[$i]:'';
					$blockName=(isset($blockName))?$blockName:"";
					$varName=(isset($blockName))?$blockName:"";
					if($end)break;
					switch($d){
						case " ":
						case "\n":
						case "\r":($state!="varValueNeed")?$i++:false;
						case "[":
							$state=($state=="none")?"blockInit":$state;
							break;
						case ".":
							if($state=="blockInit"){
								$state="blockNameNeed";
							}
							break;
						case "]":
							if($state=="blockName"){
								$state="blockNameExit";
							}
							break;
						case "=":
							if($state=="varName"){
								$state="varNameExitNeed";
							}elseif($state!="varValue"){
								die("syntax error at symbol ".$i." !");
							}
							break;
						case "\"":
						case "\'":
							//die($state);
							if($state=="varValueNeed"){
								$state="varValue";
							}elseif($state!="varValue"){
								die("syntax errorLINE241!");
							}
							break;
						case ";":
							#print $i."<br/>";
							if($state=="varValue"){
								$state="varValueExitNeed";
							}else{
								die("syntax error!LINE23");
							}
							break;
						default:
							switch($state){
								case 'varValue':
									break;
								case 'varName':
									break;
								case 'blockName':
									die(print_r(get_defined_vars()));
									break;
								case 'blockNameNeed':
									$state="blockName";
									break;
								default:
									$state='varNameNeed';
							}
							break;
					}
					switch($state){
						case "blockInit":
							$blockName="";
							break;
						case "blockName":
							$blockName.=$d;
							break;
						case "blockNameExit":
							if($blockName=="end"){
								$end=1;
							}
							$blocks[$blockName]=array();
							$lb=$blockName;
							break;
						case "varNameNeed":
							$state="varName";
							$varName="";
							break;
						case "varName":
							$varName.=$d;
							break;
						case "varValueNeed":
							$blocks[$lb][$lv].=$d;
							break;
						case "varNameExitNeed":
							$state="varValueNeed";
							$blocks[$lb][$varName]="";
							$lv=$varName;
							break;
						case "varValueExitNeed":
							//die($d);
							$state="varNameNeed";
							break;
						case "none":
						default:
							break;
					}
					$i++;
				}
				//print_r($blocks);
			}
		}
	}
}
?>