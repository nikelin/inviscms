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
class html implements htmlI
{
	function __construct(){
	}
	
	public function renderPubFeed($data)
	{
		$result=null;
		
		for($i=0;$i<count($data);$i++)
		{
			$row=$data[$i];
			$title=$tools->decodeString($row['title']);
			$description=$tools->decodeString($row['description']);
			$result.="<div class='item' style='margin-bottom:3px;display:block;text-align:left;'>
						<strong>".date("d.m.Y",$row['pub_date'])."</strong> - <a href='/articles/".substr(md5($row['id']),0,6)."' style='text-decoration:none;' title='Читать \"".$title."\"' ><strong style='color:#0000AA;'>".$title."</strong></a><br/>
						".$description."
						<a href='/articles/".substr(md5($row['id']),0,6)."' style='margin:0;padding:0;text-align:left;display:block;text-decoration:none;' title='Читать \"".$title."\"'><strong style='border:0px dotted #000000;border-bottom-width:2px;'>Читать далее</strong></a>
					</div>";
		}
		return $result;
	}
	

	public function renderMenu($part,$data)
	{
		$result=null;
		
		if(is_array($data) && count($data)>0)
		{
			$result.='<ul>';
			for($i=0;$i<count($data);$i++)
			{
				switch($part)
				{
					case 'vertical':
						$result.='<li><a href="'.(($data[$i]['target']=='both')?$data[$i]['link']:'javascript:window.location.href=\''.$data[$i]['link'].'\';return false;').'" title="'.$data[$i]['alt'].'">'.rawurldecode($data[$i]['title']).'</a></li>';
						break;
					case 'horizontal_bottom':
					case 'horizontal_top':
					default:
						$row=$data[$i];
						$result.="<li>";
						$result.="<div style='height:25px;text-align:center;background-image:url(/images/sys/menusep.gif);margin:0;padding:0;padding-top:2px;'>";
						$result.="<a href='/".$row['link']."'  title='".rawurldecode($row['alt'])."' target='_both' style='text-align:center;color:#FFFFFF;width:100%;'>".rawurldecode($row['title'])."</a>";
						$result.="</div></li>";
						break;
				}
			}
			$result.='</ul>';
		}
		return $result;
	}
	
	public function renderPage($data){
			return "<div class='page'>
										 <div class='head'>
										 			<h2>".rawurldecode($data['title'])."</h2>
										 </div>
								     <div class='body'>
								          <div style='text-align:left;font-size:18px;'>
								               ".rawurldecode(stripslashes($data['text']))."
													</div>
										 </div>
								</div>
								<hr/>";
	}
	
	public function renderUserLanguagePanel($data)
	{
		$result=null;
		if(is_array($data) && count($data)!=0)
		{
			$result.='<option></option>';
			foreach($data as $k=>$v)
			{
				$result.="<option value='".substr(md5($k),0,6)."'>";
				$result.=rawurldecode($v);
				$result.="</option>";
			}
		}
		return $result;
	}
	
	public function renderBlocks($data)
	{
		$result=null;
		$html=&$GLOBALS['html'];
		$uinterface=&$GLOBALS['uinterface'];
		$tools=&$GLOBALS['tools'];
		$system=&$GLOBALS['system'];
		$database=&$GLOBALS['database'];
		for($i=0;$i<count($data);$i++)
		{
			$row=$data[$i];
			if(trim($row['title'])=='')
			{
				$single=false;
			}else{
				$single=true;
			}
			$result.="<div class='item' id='".rawurldecode($row['name'])."' style='margin-bottom:10px;'>";
			if($single!=false){
				$result.=$this->topRounded("100%");
				$result.="<div class='item_logo' style='background-image:url(/images/block_title.png);background-repeat:repeat-x;color:#555555;display:block;text-align:center;font-size:15px;font-weight:bold;font-family:Tahoma, Arial'>";
				$result.=rawurldecode($row['title']);
				$result.="</div>";
				$result.="</div>";
			}
			$result.="<div style='".(($single!=false)?"background-color:#ffffef;":"")."margin:0px;margin-top:1%;padding-top:3px;padding-left:10px;padding-right:10px;".(($single)?"border:0px #000000 dotted; border-bottom-width:2px;":"")."padding-bottom:10px;'>";
			ob_start();
			eval('?>'.stripslashes(rawurldecode($row['content'])));
			$dat=ob_get_contents();
			ob_end_clean();
			$result.=$dat;
			$result.="</div>";
		}
		return $result;
	}
	
	public function topRounded($width="100%",$margins=''){
		return '<div id="nifty" style="width:'.$width.';'.$margins.'">
			    <b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>';
	}
	
	public function bottomRounded(){
		return '<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
		</div>';
	}
}
?>
