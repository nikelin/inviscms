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

	public function render_banner($data)
	{
		$result=null;
		if(is_array($data))
		{
			$result.="<a href='/goto/".$data['id']."/".mt_rand(11111,99999)."' title='".$data['alt']."'>";
			$result.="<img src='/bnrimg.php?bid=".substr(md5($data['id']),0,6)."' alt='Баннерная реклама на ФутболкаPrint'/>";
			$result.="</a>";
		}
		return $result;
	}
	public function renderMenu($part,$data)
	{
		$result='';
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
		}else
		{
			$result=HTML_MENU_PE2;
		}
		return $result;
	}
	
	public function renderPage($data){
		/**
				        * $data['title']
				        * $data['text']
				        * $data['references']
				        * $data['views']
				        * $data['mark']
				        * $data['votes']
				        * $data['pubDate']
			          **/
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
	public function render_catergories_links($data)
	{
		$result='';
		if(is_array($data) && count($data)!=0)
		{
			$result="<div style='clear:both;width:80%;margin-bottom:10px;background-color:#CCCCCC;'>";
			for($i=0;$i<count($data);$i++)
			{
				$row=$data[$i];
				$result.="<a href='/cats/".$row['id']."' style='font-weight:bold;color:#007700;' title='{^shirts_in_cat^}Футболки в категории ".$row['title']."'>".rawurldecode($row['title'])."</a>&nbsp;&nbsp;";
				if($i!=0 && $i%10==0)$result.="<br/>";
			}
			$result.="</div>";
		}
		return $result;
	}
	public function render_user_lang_bar($data)
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
	
	public function render_blocks($data)
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
			$result.="</div>";
		}
		return $result;
	}
	public function render_goods_list($data)
	{
		$result.="<div class='items' style='margin-top:30px;clear:both;display:block;margin-left:10px;'>";
		for($i=0;$i<count($data);$i++)
		{
			$result.="<div class='newItems' style='width:170px;margin:4px;float:left;margin-right:10px;'>";
			$result.="<div style='width:100%;'>";
			$result.=$this->topRounded("100%");
			$result.="<div class='title' style='background-color:#FFFFFF;height:30px;display:block;'>".$data[$i]['title']."</div>";
			$result.="<span style='text-align:center;display:block;background-color:#EEEEEE;'>";
			$result.="<a href='/info/".substr(md5($data[$i]['id']),0,6)."' title='{^detail_info^} \"".$data[$i]['title']."\"'>";
			$result.="<img alt='{^detail_info^}\"".$data[$i]['title']."\"' src=\"/previews.php?type=product&p=".substr(md5($data[$i]['id']),0,6)."\" ";
			$result.="style='width:190px;height:190px;' src='#' />";
			$result.="</a>";
			$result.="</span>";
			$result.="<div style='clear:both;'>";
			$result.="<span style='margin-top:4px;font-weight:bold;font-size:14px;display:block;width:100%;background-color:#FFFFFF;'>";
			$result.="<h2 style='display:inline;color:#AA0000;text-decoration:underline;'>".($data[$i]['price']-$data[$i]['price']*($data[$i]['discount']/100))."грн";
			if($data[$i]['discount']!=0){
				$result.="<sup style='font-size:13px;color:#00AA00;'>-".$data[$i]['discount']."%</sup>";
			}
			$result.="</h2>";
			$result.="</span>";
			$result.="<button style='font-weight:bold;width:100%;' onclick='window.location.href=\"/info/".substr(md5($data[$i]['id']),0,6)."\";return false;' title='{^detail_info^} \"".$data[$i]['title']."\"'>";
			$result.="{^details^}";
			$result.="</button>";
			$result.="<button style='font-weight:bold;width:100%;' onclick='window.location.href=\"/basket/add/".substr(md5($data[$i]['id']),0,6)."\";return false;' title='{^to_basket^} \"".$data[$i]['title']."\"'>";
			$result.="{^to_basket^}";
			$result.="</button>";
			$result.="</div>";
			$result.=$this->bottomRounded();
			$result.="</div>";
			$result.="</div>";
		}
		$result.="</div>";
		return $result;
	}			
	
	public function renderRunningString($data)
	{
		$result=false;
		if(is_array($data) && count($data)>0)
		{
			for($i=0;$i<count($data);$i++){
				$row=$data[$i];
						 ?>
						 <div style='display:inline;'>
						      <span style='margin-left:2px;font-weight:bold;'><?=$row['title'];?></span>
						      <span><?=substr($row['text'],0,100);?>....</span>
								  {^pub_date^}: <?=date("d.m.Y",$row['pub_date']);?></span>
									<a style='border:1px #FF0000 double;font-size:13px;background-color:#FFFFFF;' href='/<?=($row['ufu']!='')?$row['ufu']:$row['id'];?>' alt="Ознайомитися з новиною '<?=$row['title'];?>'"><u>Детальніше</u></a>
						 </div>
						 <?
			}
		}else
		{
			$result=HTML_WRONG_PARAM;
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

	public function renderMarquee($data)
	{
		$result=null;
		if(is_array($data))
		{
			for($i=0;$i<count($data);$i++)
			{
				$idh=substr(md5($data[$i]['id']),0,6);
				$result.="<div style='text-align:center;float:left;margin-right:35px;'>";
				$result.="<a href='/info/".$idh."' title='{^detail_info^}'>";
				$src=$GLOBALS['database']->getSQLParameter("files","src",array("id"=>$GLOBALS['database']->getSQLParameter("labels","fid",array("id"=>$data[$i]['lid']))));
				#die($src);
				$result.="<img src='".$src."' style='height:109px;margin-top:3px;' alt=' {^shirt_screenshot^}'/>";
				$result.="</a>";
				$result.="</div>";
			}
		}
		return $result;
	}
}
?>
