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
	
	public function catHasChilds($id){
		$database=$GLOBALS['database'];
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_cats` WHERE pid='".addslashes($id)."' AND status='on'");
		return ($database->isError())?0:$database->getNumrows($q);
	}
	
	#
	# FIXME: needs to add user ability to set own address of menu node
	#
	public function catsListRender($root=null){
		$database=$GLOBALS['database'];
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
							#print $el['id'];
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
	
	public function user_lang_bar()
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
		$html=$GLOBALS['html'];
		$result='';
		$result.="<div style='margin-bottom:60px;'>&nbsp;</div>";
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
		$html=&$GLOBALS['html'];
		$database=&$GLOBALS['database'];
		$side=(trim($side)=='')?'left':$side;
		$result=null;
		//BLOCKS
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
				
			}else{
				$result="Блоков нет :(....";
			}
		}else{
			$result="Ошибка диалога с БД!";
		}
		return $result;
	}
	
	public function buildMenu($place)
	{
		$database=$GLOBALS['database'];
		$html=$GLOBALS['html'];
		$res=array();
		$q=$database->getRows('menu','*',array('place'=>$place,'status'=>'on'));
		while($row=$database->fetchQuery($q)){
			$res[]=$row;
		}
		$result=$html->renderMenu($place,$res);
		return $result;
	}
	
	
	#
	# REFACTORING: must use `html` package rendering abilities
	#
	public function getPubFeed($count=5,$related=null)
	{
		$result=null;
		$tools=&$GLOBALS['tools'];
		$database=&$GLOBALS['database'];
		$related=($related)?"AND keywords LIKE '%".$related."% ":'';
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_pages` WHERE type='pub' AND status='on' ".$keywords." ORDER BY `pub_date` ASC LIMIT 0,".(($count!=0)?$count:5));
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				while($row=$database->fetchQuery($q))
				{
					$title=$tools->decodeString($row['title']);
					$description=$tools->decodeString($row['description']);
					$result.="<div class='item' style='margin-bottom:3px;display:block;text-align:left;'>
						<strong>".date("d.m.Y",$row['pub_date'])."</strong> - <a href='/articles/".substr(md5($row['id']),0,6)."' style='text-decoration:none;' title='Читать \"".$title."\"' ><strong style='color:#0000AA;'>".$title."</strong></a><br/>
						".$description."
						<a href='/articles/".substr(md5($row['id']),0,6)."' style='margin:0;padding:0;text-align:left;display:block;text-decoration:none;' title='Читать \"".$title."\"'><strong style='border:0px dotted #000000;border-bottom-width:2px;'>Читать далее</strong></a>
					</div>";
				}
			}else{
				$result='Публикации не найдены';
			}
		}else{
			$result='Ошибка во время диалога с БД!';
		}
		return $result;
	}
}
?>