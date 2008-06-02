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
class uinterface
{
	public $elems=array() ;
	public $instances=array();
	
	public function currentPageParts($mod)
	{
		$result=array(
								'description'=>'',
								'title'=>'',
								'keywords'=>'',
								'css'=>'',
								'scripts'=>'',
								'rss'=>''
							);
		if(@include(MOD_DIR_PATH.'/'.$mod."/rules.php"))
		{
			$result['description']=description();
			$result['title']=slug();
			$result['keywords']=keywords();
		}
		if($data=@simplexml_load_file(MOD_DIR_PATH.'/'.$mod."/config.xml"))
		{
			if(isset($data->css))
			{
				if(isset($data->css->item))
				{
					for($i=0;$i<count($data->css->item);$i++)
					{
						$ob=$data->css->item[$i];
						$result['css'].="<link rel='stylesheet' href='".$ob['href']."' type='".$ob['type']."' media='".$ob['media']."'/>";
					}
				}else
				{
					if($data->css['href']!='')
						$result['css'].='<link rel="stylesheet" type="'.$data->css['type'].'" href="'.$data->css['href'].'" media="'.$data->css['media'].'"/>';
				}
			}
			if(isset($data->rss))
			{
				if(isset($data->rss->item))
				{
					for($i=0;$i<count($data->rss->item);$i++)
					{
						$ob=$data->rss->item[$i];
						if($ob['href']!='')
							$result['rss'].="<link rel='alternate' href='".$ob['href']."' type='".$ob['type']."'/>";
					}
				}else
				{
					if($data->rss['href']!='')
						$result['rss'].='<link rel="alternate" type="'.$data->css['type'].'" href="'.$data->rss['href'].'"/>';
				}
			}
			
			if(isset($data->scripts))
			{
				if(isset($data->scripts->item))
				{
					for($i=0;$i<count($data->scripts->item);$i++)
					{
						$ob=$data->scripts->item[$i];
						if($ob['href']!='')
						{
							$result['scripts'].=('Invis.tools.loadLib("js","'.$data->scripts['href'].'");'."\n");
						}
					}
				}else
				{
					if($data->scripts['href']!='')
					{
						$result['scripts'].=('Invis.tools.loadLib("js","'.$data->scripts['href'].'");'."\n");
					}
				}
			}	
		}
		return $result;
	}
	
	public function catHasChilds($id){
		// InheritsSection: {
		$database=&$GLOBALS['database'];
		// };
		
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_cats` WHERE pid='".addslashes($id)."' AND status='on'");
		return ($database->isError())?0:$database->getNumrows($q);
	}
	public function catsListRender($root=null){
		// InheritsSection: {
		$database=&$GLOBALS['database'];
		
		# FIX: `code` -> `presentation`
		$depth=0;
		$res=null;
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_cats` WHERE status='on' ORDER by `pid` ASC");
		$res='<ul class="cats_list" style="margin:0;padding:0;margin-left:20px;font-size:15px;font-weight:bold;">';
		if(!$database->isError()){
			if($database->getNumrows($q)!=0){
				while($el=$database->fetchQuery($q)){
					if(($root && ($el['pid']!=$root || $el['pid']==-1)) || (!$root && $el['pid']!=-1))
					{
						continue;
					}else{
						$childs=$this->catHasChilds($el['id']);
						$idName=md5($el['id']).'_'.$depth++;
						$res.='<li class="item" style="padding:0;margin:0;margin-top:4px;text-align:left;list-style:none;">';
						$res.=($childs)?'<span style="background-color:#EEEEEE;border:1px #AA33F0 dotted;height:10px;padding:0;margin-right:5px;font-weight:bold;font-size:15px;cursor:pointer"
									onclick="Invis.tools.changeElVis(\''.$idName.'\',\'switch\');">+</span>':"";
						$res.='<a style="color:#00AA00;padding-left:20px;background-position:left;background-image:url(/images/cur.gif);background-repeat:no-repeat;"
								href="/cats/'.$el['id'].'" ';
						$res.=' title="Go to URL">'.rawurldecode($el['title']).'</a>';
						$res.='</li>';
						if($childs){
							$depth++;
							$res.='<ul id="'.$idName.'" class="cats_list" style="display:none;background-color:#EEEEEE;border:0px #999999 dotted;border-left-width:2px;padding:0;margin:0;margin-left:12px">'.$this->catsListRender($el['id']).'</ul>';
						}
					}
				}
			}else{
				$res.='<li style="padding:0;margin:0;text-align:left;font-size:12px;">{^cats_not_exists^}Разделы не найдены !</li>';
			}
		}else{
			$res.=DATABASE_PROCEED_ERROR;
		}
		$res.='</ul>';
		return $res;
	}
	public function userLanguagePanel()
	{
		$database=&$GLOBALS['database'];
		$html=&$GLOBALS['html'];
		$result=null;
		$q=$database->getRows("dicts","*");
		if(!$database->isError($q))
		{
			if($database->getNumrows($q)!=0)
			{
				$data=array();
				while($row=$database->fetchQuery($q))
				{
					$data[$row['id']]=$row['name'];
				}
				$result=$html->render_user_lang_bar($data);
			}
		}
		return $result;
	}
	
	public function getUIParam($name,$lang)
	{
		return $GLOBALS['i18n']->lngParse($GLOBALS['database']->getSQLParameter("settings",$name,1),$lang);
	}
	
	public function buildClientPage($indefier)
	{
		// InheritsSection: {
		$database=$GLOBALS['database'];
		$html=$GLOBALS['html'];
		
		$where=array((is_string($indefier)?"ufu":"id")=>$indefier,'status'=>'on');
		if($database->checkRowExists("pages",$where))
		{
			$q=$database->updateRow("pages",array("views"=>"views+1"),array((is_string($indefier)?"ufu":"id")=>$indefier));
			$q=$database->getRows("pages","*",$where);
			if(!$database->isError())
			{
				$result=$html->renderPage($database->fetchQuery($q));
			}else
			{
				$result=DATABASE_PROCEED_ERROR;
			}
		}else
		{
			$q=$database->updateRow("pages",array("views"=>"views+1"),array("frontpage"=>'1'));
			$result=$html->renderPage($database->fetchQuery($database->getRows("pages",'*',array("frontpage",1))));
		}
		return $result;
	}
	
	public function buildActionsTab($module,$pairs)
	{
		// InheritsSection: {
		$html=$GLOBALS['html'];
		
		$result="<div style='margin-bottom:60px;'>&nbsp;</div>";
		$result.=$html->topRounded("100%");
		$result.='<div class="actionTabs">';
		$result.='<span>Выбранные элементы:</span>';
		$result.="<select onchange='document.forms[0].submit();' name='action'>";
		$result.="<option></option>";
		foreach($pairs as $k=>$v){
			$result.="<option value='".$k."'>".$v."</option>";
		}
		$result.="</select></div>";
		return $result;
	}
	
	public function block_place($side)
	{
		// InheritsSection: {
		$html=&$GLOBALS['html'];
		$database=&$GLOBALS['database'];
		// };
		
		$result=null;
		$side=(trim($side)=='') ? 'left' : $side;
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_blocks` WHERE status='on' AND place='".$side."' ORDER by `pos`");
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				$data=array();
				while($data[]=$database->fetchQuery($q))
				{
				}
				$result=$html->render_blocks($data);
				
			}
		}
		return $result;
	}
	public function buildMenu($place)
	{
		// InheritsSection: {
		$database=$GLOBALS['database'];
		$html=$GLOBALS['html'];
		// };
		
		$res=array();
		$q=$database->getRows('menu','*',array('place'=>$place,'status'=>'on'));
		while($row=$database->fetchQuery($q)){
			$res[]=$row;
		}
		$result=$html->renderMenu($place,$res);
		return $result;
	}
	
	
	# Change this function to present current user site path
	
	public function getCatalogPath($curr_cat,$recursive=false)
	{
		$database=&$GLOBALS['database'];
		$data='';
		if($curr_cat && $database->checkRowExists("cats",array("id"=>$curr_cat)))
		{
			if($recursive)
			{
				$q=$database->proceedQuery("SELECT id,title,pid FROM `#prefix#_cats` WHERE id='".$curr_cat."'");
				if(!$database->isError())
				{
					$data=$database->fetchQuery($q);
					if($data['pid']!=-1)
					{
						return ("<a href='/home' style='font-size:18px;color:#000000;text-decoration:none;'><strong>Главная</strong></a>->&nbsp;&nbsp;".($this->getCatalogPath($data['pid'],true).'&nbsp;&nbsp;->&nbsp;&nbsp;<a href="/cats/'.$data['id'].'" style=font-size:18px;" title="Перейти к категории `'.$data['title'].'`"><strong>'.$data['title']).'</strong></a>');
					}else{
						return ('<a href="/cats/'.$data['id'].'" title="Перейти к категории `'.$data['title'].'`" style="font-size:18px;"><strong>'.$data['title'].'</strong></a>');
					}
				}else{
					die("Error!");
				}
			}else
			{
				return $database->getSQLParameter("cats","title",array(is_numeric($curr_cat)?"id":"LEFT(MD5(id),".strlen($curr_cat)=>$curr_cat));
			}
		}else{
			return"<a href='/' style='font-size:18px;color:#000000;text-decoration:none;'><strong>Главная</strong></a>";
		}
	}
	
	public function getPubFeed($count=5,$related=null)
	{
		// InheritsSection: {
		$tools=&$GLOBALS['tools'];
		$database=&$GLOBALS['database'];
		// };
		
		#FIX: `code` -> `presentation` 
		
		$result=null;
		$related=($related)?"AND keywords LIKE '%".$related."% ":'';
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_pages` WHERE type='pub' AND status='on' ".$keywords." ORDER BY `pub_date` ASC LIMIT 0,".(($count!=0)?$count:5));
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				while($row=$database->fetchQuery($q))
				{}
				$result=$html->renderPubFeed($row);
			}
		}
		return $result;
	}
}
?>