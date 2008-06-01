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
class i18n
{
	
	public function remeberUserLang($lang)
	{
		$sessions=&$GLOBALS['sessions'];
		if(strlen($lang)==6)
		{
			$sessions->registerData("lang",$lang,array(time(),3600*60),true);
		}else{
			$sessions->registerData("lang",$this->delaultLang(),array(time(),3600*60),true);
		}
	}
	
	public function currentLanguageSet()
	{
		if(isset($GLOBALS['mod']) && $GLOBALS['mod']=='lang')
		{
			$result=$sessions->registerData("lang",$i18n->getLandId($GLOBALS['params']['params'][0]),3600*60);
		}else{
			$result=$sessions->registerData("lang",$i18n->delaultLang(),3600*60);
		}
		return $result;
	}
	
	/**
	 * Get current language-scheme
	 *
	 * @return unknown
	 */
	public function getLangID()
	{
		$database=&$GLOBALS['database'];
		$sessions=&$GLOBALS['sessions'];
		if(!$sessions->isDeath("lang"))
		{
			$lang=$sessions->getData("lang");
			return $database->getSQLParameter("dicts","id",array((is_numeric($lang)?"id":"LEFT(MD5(id),".strlen($lang).")")=>$lang));
		}else{
			return $this->delaultLang();
		}
	}
	
	public function delaultLang()
	{
		return $GLOBALS['database']->getSQLParameter("settings","lang");
	}
	
	public function initializeDictionary($parser)
	{
		if(get_class($parser)=="invisparser")
		{
			$invisparser=$parser;
			$database=&$GLOBALS['database'];
			$q=$database->getRows("texts","*",array("partition"=>"dicts","param"=>$this->getLangID()));
			if(!$database->isError())
			{
			   if($database->getNumrows($q)!=0)
			   {
			      while($row=$database->fetchQuery($q))
			      {
			        $invisparser->assign($row['name'],rawurldecode($row['value']));
			      }
			   }else{
			    die("Dictionary initializing error!");
			   }
			 }
			}
		}
	
	public function extractMultilingualFields($data)
	{
		$multi=array();
		foreach($data as $k=>$v)
		{
			$d=preg_match_all('/(.*)_lng_(.*)/',$k,$r);
			if($d!=0){
				if(array_key_exists($r[1][0],$multi))
				{
					$multi[$r[1][0]][$r[2][0]]=$v;
				}else{
					$multi[$r[1][0]]=array($r[2][0]=>$v);
				}
			}
		}
		return $multi;
	}
	
	public function prepareMultilingual($data)
	{
		$result=array();
		if(is_array($data) && count($data)!=0)
		{
			foreach($data as $k=>$v){
				$result[$k]['data']='<?xml version="1.0" encoding="UTF-8"?>';
				$result[$k]['data'].='<data>';
				foreach($v as $c=>$d){
					$result[$k]['data'].="<lng_".$c.">".$d."</lng_".$c.">";
				}
				$result[$k]['data'].='</data>';
			}
		}
		return $result;
	}
	
	public function getLangs()
	{
		$result=array();
		$database=&$GLOBALS['database'];
		$q=$database->getRows("dicts",array("id","name"));
		if(!$database->isError())
		{
			while($data=$database->fetchQuery($q)){$result[]=$data;}
		}
		return $result;
	}
	
	public function lngParse($data,$lng)
	{
		$result=null;
		if(false!==($data=@simplexml_load_string(stripslashes($data))))
		{
			$lng='lng_'.substr(md5($lng),0,6);
			$result=(String)$data->$lng;
		}
		return $result;
	}
}
?>