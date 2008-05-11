<?php
include "./lib/kernel/others/init.php";
function ext_info_block($phash,$part,$id,$title)
{
		$result="<div class='row'><div class='col' style='clear:both;width:100%;text-align:center;font-style:italic;'>".$title."</div></div>
			<div id='".$id."_".$phash."'>";
			if(count($part->item)!=0)
			{
				for($i=0;$i<count($part->item);$i++)
				{
					$name=$part->item[$i]['name'];
					$hash=substr(md5($id.$name),0,6);
					$result.="<div class='row' id='".$id."_".$hash."'>
									<div class='col' style='width:100%;clear:both;'>
										Element <strong>#".$i."</strong>: <input type='text' name='".$id."[]' value='".$name."'/>
										<button onclick=\"deleteExt('".$hash."');return false;\" style='width:20px;height:25px;font-size:15px;font-weight:bold;'>-</button>
										<button onclick='addExt(\"".$id."\",\"".$phash."\");return false;' style='width:20px;height:25px;font-size:15px;font-weight:bold;'>+</button>
									</div>
								</div>";
				}
			}else
			{
				$result.="<div class='row'>
									<div class='col' style='width:100%;clear:both;'>
										<button onclick='addExt(\"".$id."\",\"".$phash."\");return false;'>New extension</button>
									</div>
				</div>";
			}
			$result.="</div>";
			return $result;
}
?>
<html>
	<head>
		<link rel='stylesheet' href='./lib/gt/table.css' type='text/css'/>
		<script type='text/javascript' src='/lib/gt/invis.js'></script>
		<script type='text/javascript'>
			var Invis=new Invis();
			var addExt=function(id,phash)
			{
				var el=document.getElementById(id+'_'+phash);
				if(el)
				{
					var ext=document.createElement("div");
					var ext_c1=document.createElement("div");
					ext.setAttribute('class','row');
					hash=id+'_'+phash+'_'+phash.substr(0,10);
					ext.setAttribute('id',hash);
					ext_c1.setAttribute("class","col");
					ext_c1.setAttribute('style','width:100%;clear:both;');
					ext_c1.innerHTML="Element: <input type='text' name='"+id+"[]'/>";
					ext_c1.innerHTML+="<button onclick=\"deleteExt('"+hash+"';return false;\" style='width:20px;height:25px;font-size:15px;font-weight:bold;'>-</button>";
					ext_c1.innerHTML+="<button onclick='addExt(\""+id+"\",\""+phash+"\");return false;' style='width:20px;height:25px;font-size:15px;font-weight:bold;'>+</button>";
					ext.appendChild(ext_c1);
					el.appendChild(ext);
				}
			}
		</script>
		<style type='text/css'>
			<!--
			.table .body .row{height:45px;margin:2px;padding:0;}
			.table .body .row .col{height:auto;min-height:20px;margin:0;padding:0;}
			button{height:25px;font-size:12px;padding:0;text-align:center;}
			-->
		</style>
	</head>
	<body>
	<h2>Текущий репозиторий модулей</h2>
	<?php
	if(isset($_POST['index']))
	{
	}elseif(isset($_POST['apply']))
	{
		$data=$tools->getEnvVars("POST",false);
		$res="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
				<info>
				<status value='".$data['status']."'/>
			    <authority>
			    	<title>".$data['title']."</title>
					<author>".$data['author']."</author>
					<url>".$data['url']."</url>
					<email>".$data['email']."</email>
					<company>".$data['company']."</company>
					<license>".$data['license']."</license>
					<license_url>".$data['license_url']."</license_url>
					<version>".$data['version']."</version>
					<regcode>".$data['regcode']."</regcode>
					<pubdate>".$data['pub_date']."</pubdate>
					<reply_to>".$data['reply_to']."</reply_to>
			    </authority>
			    <dependencies>
				<abstractions>";
				for($i=0;$i<count($data['abstactions']);$i++)
				{
					$res.="<item name='".$data['abstractions'][$i]."'/>";
				}
				$res.="</abstractions>
					<interfaces>";
				for($i=0;$i<count($data['interfaces']);$i++)
				{
					$res.="<item name='".$data['interfaces'][$i]."'/>";
				}
				$res.="</interfaces>";
				$res.="<errors>";
				for($i=0;$i<count($data['errors']);$i++)
				{
					$res.="<item name='".$data['errors'][$i]."'/>";
				}
				$res.="</errors>";
				$res.="<extending>";
				for($i=0;$i<count($data['extending']);$i++)
				{
					$res.="<item name='".$data['extending'][$i]."'/>";
				}
				$res.="</extending>";
				$res.="<libs>";
				for($i=0;$i<count($data['libs']);$i++)
				{
					$res.="<item name='".$data['libs'][$i]."'/>";
				}
				$res.="</libs>";
			    $res.="</dependencies>
			</info>";
			#die_r($res);
			if($fp=@fopen("./lib/core/packages/".$data['id']."/info.xml","w+"))
			{
				if(@fwrite($fp,$res))
				{
					print "<span style='color:#00AA00;'>Настройки пакета ".$data['id']." успешно сохранены !</span>";
					if(fclose($fp) && $fp=@fopen("./core/packages/".$data['id']."/readme.txt","w+"))
					{
						if(@fwrite($fp,$data['readme']))
						{
							print "<br/><span style='color:#00AA00;'>Readme для пакета ".$data['id']." успешно сохранен !</span>";
						}else
						{
							print "<span style='color:#AA0000;'>Ошибка записи Readme!</span>";
						}
					}else
					{
						print "<span style='color:#00AA00;'>Не могу открыть на запись Reame !</span>";
					}
				}else
				{
					print "<span style='color:#AA0000;'>Ошибка сохранения настроек пакета ".$data['id']." успешно сохранены !</span>";
				}
			}else
			{
				print "<span style='color:#AA0000;'>Ошибка записи в файл !</span>";
			}
			fclose($fp);
	}
	$path="./lib/modules";
	$dir=opendir($path);
	for($f=readdir($dir);($f!==false);$f=readdir($dir))
	{
		if($f!='..' && $f!='.')
		{
			$configs=@simplexml_load_file($path.'/'.$f.'/comfig.xml');
			$authority=@simplexml_load_file($path.'/'.$f.'/authority.xml');
			$readme=@simplexml_load_file($path.'/'.$f.'/readme.xml');
			$status=$data->status['value'];
			$phash=substr(md5($f),0,6);
			$indexated=$database->checkRowExists("packages",array("title"=>$data['title']));
			?>
			<form action='' method='post'>
			<input type='hidden' name='id' value='<?=$f;?>'/>
			<div class='table' style='margin-bottom:40px;border:3px #000000 dashed;'>
				<h4 style='background-color:#EEEEEE;' onclick='Invis.tools.changeElVis("<?=$phash;?>","switch");return false;'><a name='<?=md5($f);?>'/>Module title: <input type='text' name='title' value='<?=($configs->title)?$configs->title:$f;?>'/>(status:<input type='text' name='status' style="color:<?=($status=="on")?"#00FF00":"FF0000";?>;" value='<?=$status;?>'/>) <?=($indexated)?'Alredy added to index':"Not indexed in database";?></h4>
				<div style='display:none' id='<?=$phash;?>'>
					<strong>Information about module:</strong>
					<div class='body'>
						<div class='row'>
							<div class='col'>System name:</div>
							<div class='col'><input type='text' name='name' value='<?=f</div>
						</div>
					</div>
					<strong>Authority information:</strong>
					<strong>Authority information:</strong>
					<div class='body'>
						<div class='row'>
							<div class='col'>Indexation status:</div>
							<div class='col'><?=($indexated==true)?'Alredy indexed':"Not indexed in database";?></div>
						</div>
						<div class='row'>
							<div class='col'>Package author:</div>
							<div class='col'><input type='text' name='author' value='<?=$data->authority->name;?>'/></div>
						</div>
						<div class='row'>
							<div class='col' style='font-weight:bold;'>Dependencies:</div>
						</div>
						<?=ext_info_block($phash,$data->dependencies->packages,"abstractions","Abstracted classes:");?>
					<div class='row'>
						<div class='col' style='text-align:center;width:100%;clear:both;'>
							<button style='font-weight:bold;' name='apply'>Применить изменения</button>
							<button style='font-weight:bold;' name='apply'>Добавить к индексу</button>
						</div>
					</div>
				</div>
				</div>
			</div>
			</form>
			<?
		}
	}
	?>
	</body>
</html>