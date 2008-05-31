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
   class search
   {
   	 private $terms=array();
	 private $quanter='';//0|1
	 private $exclusion=array();
	 private $important=array();
   	 private $delimiters=array(',','.','-',' ',':',';','?');
	 
	 
	 public function excludeTerm($term)
	 {
	 	$this->exclusion[]=$term;
	 }
	 
	 public function setImportant($term)
	 {
	 	$this->important[]=$term;	
	 }
	 
	 
   	 public function prepareQuery($data)
	 {
	 	$pos=0;
		$process=true;
		$quoted="";
	 	while($pos<=strlen($data))
		{
			$d=substr($data,$pos,1);
			if(!$quoted){
				//Если $d - разделитель - завершить текущее слово,
				//и перейти к обработке следующего
				if(($d=='"' || $d=="'") && $this->calcFrequence($d,$data)>1)
				{
					$quoted=($quoted)?true:false;
				}elseif(in_array($d,$this->delimiters))
				{
				  if(in_array($temp,$words)){
					$this->setTermRank($this->getTermRank($temp)+1);
				  }else{
				  	$temp='';
					$this->addNewTerm($temp,1);
					switch($d){
						case '!':
						case '-':
						 $this->excludeTerm($term);
						 break;
						case '+':
						 $this->setImportant($term);
						 break;
					}
				  }
				}else{
					$temp.=$d;
				}
			}else{
				$temp.=$d;
			}
			$pos++;
		}
	 }
	 public function setSource($source)
	 {
	 	if($database->_tableExists($source))
		{
	 		$this->source=$source;
	 	}
	 }
	 
	 public function setQuanter($value)
	 {
	 	$this->quanter=($value)?1:0;
	 }//OR | AND
	 
	 public function limitResult($value)
	 {
	 	$this->limit=$value;
	 }//(0,inf)
	 
	 public function sourceField($value="all")
	 {
	 	if($value="all")
		{
			$this->_field=$value;
		}else{
		 	if($this->_fieldExists($value))
			{
				$this->_field=$value;
			}
		}
	 }
	 
	 public function calcFrequence($word,$data)
	 {
	 	$result=0;
	 	if(in_array($word,$this->terms) && !in_array($word,$this->exclude))
		{
			while(false!==($d=strpos($data,$word)))
			{
				$result++;
			}
		}
		return $result;
	 }
	 
	 public function calcRelevance($data){
	
	 }
	 
	 public function getNoiceLevel($data)
	 {
	 	return preg_match_all('/([^a-z0-9]{1,1})/im',$data,$d);
	 }
	 
	 public function sortResult(){}
   }
?>
