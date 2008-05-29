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
//Create thumbnail of tshirt to calatog and previewer
$config=simplexml_load_file('./config.xml');
if(!$config){
	die("Please as first start 'install.php' script !");
}else{
	$GLOBALS['path_to_site']=$config->param[0]['value'];
}
include "./lib/core/others/init.php";
if(isset($_GET['type']))
{
	$_GET['type']=rawurlencode($_GET['type']);
	
	switch($_GET['type'])
	{
		case 'product':
			if(!isset($_GET['p'])) die('wrong params');
			$q=$database->proceedQuery("SELECT coords, tid, lid,
									(SELECT front FROM `#prefix#_templates` WHERE id=tid) AS ffid,
									(SELECT fid FROM `#prefix#_labels` WHERE id=lid) AS lfid,
									(SELECT src FROM `#prefix#_files` WHERE id=lfid) AS label_src,
									(SELECT src FROM `#prefix#_files` WHERE id=ffid) AS front_src
									FROM `#prefix#_catalog`
									WHERE status='on' AND LEFT(MD5(id),6)='".$_GET['p']."'");
			#die_r($database->fetchQuery($q));
			#die_r($database->sqlErrorString());
			break;
		case 'preview':
			if(!isset($_GET['t']) || !isset($_GET['l']) || !isset($_GET['coords'])) die('wrong params');
			$q=$database->proceedQuery("SELECT id,
											(SELECT fid FROM `#prefix#_labels` WHERE id=".$_GET['l'].") as flid,
											(SELECT front FROM `#prefix#_templates` WHERE id=".$_GET['t'].") AS tbfid,
											(SELECT src FROM `#prefix#_files` WHERE id=flid) AS label_src,
											(SELECT src FROM `#prefix#_files` WHERE id=tbfid) AS front_src
											FROM `#prefix#_labels`
											");
			#die_r($database->fetchQuery($q));
			break;
		default: die('wrong interface');
	}
	if(!$database->isError())
	{
		if($database->getNumrows($q)!=0)
		{
			#die('dasdas');
			$data=$database->fetchQuery($q);
			if($data['front_src']=='' || $data['label_src']=='')
			{
				$img=imagecreatefromjpeg("./images/noimage.jpg");
				header("Content-Type:image/png");
				imagepng($img);
				exit();
			}else{
				if($_GET['type']!='product')
				{
					$coords=$jsondecoder->decode(stripcslashes($_GET['coords']));
				}else{
					$coords=$jsondecoder->decode($data['coords']);
				}
				$img_path='./lib/files';
				$front_src=$data['front_src'];	
				$front_src=explode('.',$front_src);
				#die_r($front_src);
				$fext=$front_src[count($front_src)-1];
				#print $fext;
				$label_src=$data['label_src'];
				$label_src=explode('.',$label_src);
				$lext=$label_src[count($label_src)-1];
				$img=call_user_func('imagecreatefrom'.(($fext=='jpg')?'jpeg':$fext),$data['front_src']);
				$img2=call_user_func('imagecreatefrom'.(($lext=='jpg')?'jpeg':$lext),$data['label_src']);
				$y=$coords['y'];
				$x=$coords['x'];
				$w=$coords['width'];
				$h=$coords['height'];
				@imagecopyresized($img,$img2,$x,$y,0,0,$w,$h,imagesx($img2),imagesy($img2));
				header("Content-type:image/jpeg");
				@imageantialias($img,true);
				#@call_user_func("image".(($fext=='jpg')?'jpeg':$fext),$img,"",100);
				imagejpeg($img,"",100);
				
				die('dasdasd');
			}
		}else{
			die("there are no templates founded");
		}
	}else{
		die("database error");
	}
}else{
	$img=imagecreatefromjpeg("./images/noimage.jpg");
	header("Content-Type:image/png");
	imagepng($img);
	exit();
}
?>
