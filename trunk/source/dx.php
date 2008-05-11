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
$config=simplexml_load_file('./config.xml');
if(!$config){
	die("Please as first start 'install.php' script !");
}else{
	$GLOBALS['path_to_site']=$config->param[0]['value'];
}
 include $GLOBALS['path_to_site']."/lib/kernel/others/init.php";
$paths=array(
			"uforms"=>$GLOBALS['path_to_site'].'/lib/skins/default/uforms',
			"jallib"=>$GLOBALS['path_to_site'].'/lib/gt/jallib'
			);
if(isset($_GET['x']))
{
	switch($_GET['x']){
		case '0x17':
			if(isset($_FILES['Filedata']) && isset($_POST['email']) && $tools->isEmail($_POST['email']))
			{
				if(trim($_FILES['Filedata']['tmp_name'])=='' || $_FILES['Filedata']['size']==0)
				{
					die("form_error");
				}else{
					$client=$database->getSQLParameter("clients","id",array("email"=>$email));
					if($client==-1)
					{
						$client=$database->insertRow("clients",array("","",$_POST['email'],"",time(),"","",$_SERVER['REMOTE_ADDR'],'off'));
					}
					$client=($client==-1)?$_POST['email']:$client;
					$file=$dirs->uploadFile($_FILES['Filedata']['tmp_name']);
					$fid=$database->insertRow("files",array("",0,$_FILES['Filedata']['type'],$_FILES['Filedata']['name'],$file,time(),$_FILES['Filedata']['size'],"","uploaded","on"));
					$q=$database->insertRow("orders",array("",$client,"none",time(),$file,"maket","active"));
					if(!$database->isError())
					{
						die('db error');
					}
				}
			}else{
				die("form_error");
			}
		break;
		case '0x22':
			if(isset($_GET['data']) && $_GET['data']!=''){
				$f=$paths['uforms'].'/'.$_GET['data'].'.tpl';
				if(file_exists($f)){
					print htmlspecialchars(eval('?>'.join('',file($f))));
					#exit;
				}else{
					die("Internal script error !");
				}
			}
			break;
		case '0x173':
			$d=array();
			$d['message']='empty';
			$d['status']=0;
			//Check parameter value
			if(isset($_GET['id']))
			{
				if($database->checkRowExists('catalog',array("LEFT(MD5(id),6)"=>$_GET['id'])))
				{
					$q=$database->proceedQuery("DELETE FROM `#prefix#_catalog` WHERE LEFT(MD5(id),6)=".$_GET['id']);
					if(!$database->isError())
					{
						$d['status']=200;
						$d['message']='Элемент корзины успешно удалён!';
					}else
					{
						$d['message']='Ошибка во время удаления!';
						$d['status']=500;
					}
				}else
				{
					$d['message']='Вы не добавляли данный товар в свою корзину!';
				}
			}else
			{
				$d['message']='Ошибка во время обращения к протоколу!';
				$d['status']=500;
			}
			print $jsonencoder->encode($d);
			break;
		case '0x32':
			$d=false;
			if(isset($_GET['m']) && isset($_GET['p']))
			{
					$path=$paths['jallib'].'/'.rawurlencode($_GET['m']).'/'.rawurlencode($_GET['p']).'.jal';
					if(@file_exists($path))
					{
						$d=str_replace("\n","",@join('',file($path)));
					}else{
						$d="There are no such document!";
					}
					header("Content-Type:text/xml;charset=utf-8;");
					print $d;
			}else{
				die("Security error!");
			}
		break;
		case '0x21':
			$d=false;
			#die_r($_GET);
			if(isset($_GET['frm_name']) && $_GET['frm_name']!='' && isset($_GET['result']) && $_GET['result']!='')
			{
				$brain=$GLOBALS['path_to_site'].'/lib/core/others/forms/'.$_GET['frm_name'].'.inc';
				
				if(file_exists($brain))
				{
					@include($brain);
					#die(stripslashes($_GET['result']));
					$data=$jsondecoder->decode(stripslashes($_GET['result']));
					$d=call_user_func($_GET['frm_name'].'_main',$data[0]);
				}else{
					$d=false;
				}
			}
			print $jsonencoder->encode($d);
			break;
		case '0x41':
			$d=array();
			$d['message']='empty';
			$d['status']=0;
			if(isset($_GET['id']))
			{
				if($database->checkRowExists('basket',array("client"=>$clients->getUID(),'LEFT(MD5(id),6)'=>$_GET['id'])))
				{
					$uid=$clients->getUID();
					$q=$database->proceedQuery("DELETE FROM `#prefix#_basket` WHERE client='".$uid."' AND LEFT(MD5(id),0,6)='".$_GET['id']."'");
					#die_r($database->sqlErrorString());
					if(!$database->isError())
					{
						$d['status']=200;
						$d['message']='Элемент корзины успешно удалён!';
					}else
					{
						$d['message']='Ошибка во время удаления!';
						$d['status']=500;
					}
				}else
				{
					$d['message']='Вы не добавляли данный товар в свою корзину!';
				}
			}else
			{
				$d['message']='Ошибка во время обращения к протоколу!';
				$d['status']=500;
			}
			print $jsonencoder->encode($d);
			break;
		case '0x43':
			break;
		case '0x47':
			$d=array();
			$d['message']='Произошла внутренняя ошибка';
			$d['status']=0;
			if(isset($_GET['id']))
			{
				$uid=$clients->getUID();
				if($database->checkRowExists('basket',array("client"=>$uid,'LEFT(MD5(id),6)'=>$_GET['id'])))
				{
					$q=$database->proceedQuery("UPDATE `#prefix#_basket` SET count=".addslashes($_GET['count'])." WHERE LEFT(MD5(id),6)='".addslashes($_GET['id'])."' AND client='".$uid."'");
					if(!$database->isError())
					{
						$d['status']=200;
						$d['message']='Операция проведена успешно!';
					}else
					{
						$d['message']='Ошибка во время сохранения данных!';
						$d['status']=500;
					}
				}else
				{
					$d['message']='Вы не добавляли данный товар в свою корзину!';
				}
			}else
			{
				$d['message']='Ошибка во время обращения к протоколу!';
				$d['status']=500;
			}
			print $jsonencoder->encode($d);
			break;
		case '0x48':
			$d=array();
			$d['message']='Произошла внутренняя ошибка';
			$d['status']=0;
			if(isset($_GET['id']))
			{
				$uid=$clients->getUID();
				if($database->checkRowExists('basket',array("client"=>$uid,'LEFT(MD5(id),6)'=>$_GET['id'])))
				{
					$q=$database->proceedQuery("UPDATE `#prefix#_basket` SET count=count+1 WHERE LEFT(MD5(id),6)='".@mysql_real_escape_string($_GET['id'])."' AND client='".$uid."'");
					if(!$database->isError())
					{
						$d['status']=200;
						$d['message']='Операция проведена успешно!';
					}else
					{
						#die_r($database->sqlErrorString());
						$d['message']='Ошибка во время сохранения данных!';
						$d['status']=500;
					}
				}else
				{
					$d['message']='Вы не добавляли данный товар в свою корзину!';
				}
			}else
			{
				$d['message']='Ошибка во время обращения к протоколу!';
				$d['status']=500;
			}
			print $jsonencoder->encode($d);
			break;
		case '0x53':
			$d=array();
			$d['message']='Произошла внутренняя ошибка';
			$d['status']=0;
			$uid=($clients->getUID()!=-1)?$clients->getUID():$_SERVER['REMOTE_ADDR'];
			$q=$database->deleteRow("basket",array("client"=>$uid));
			if(!$database->isError())
			{
				$d['message']='Корзина успешно очищена!';
				$d['status']=200;
			}else{
				$d['message']='Ошибка во время диалога с БД!';
			}
			print $jsonencoder->encode($d);
			break;
		case '0x49':
			$d=array();
			$d['message']='Произошла внутренняя ошибка';
			$d['status']=0;
			if(isset($_GET['id']))
			{
				$uid=($clients->getUID()!=-1)?$clients->getUID():$_SERVER['REMOTE_ADDR'];
				if($database->checkRowExists('basket',array("client"=>$uid,'LEFT(MD5(id),0,6)'=>$_GET['id'])))
				{
					$q=$database->proceedQuery("UPDATE `#prefix#_basket` SET count=count-1 WHERE LEFT(MD5(id),6)='".@mysql_real_escape_string($_GET['id'])."' AND client='".$uid."'");
					if(!$database->isError())
					{
						$d['status']=200;
						$d['message']='Операция проведена успешно!';
					}else
					{
						#die_r($database->sqlErrorString());
						$d['message']='Ошибка во время сохранения данных!';
						$d['status']=500;
					}
				}else
				{
					$d['message']='Вы не добавляли данный товар в свою корзину!';
				}
			}else
			{
				$d['message']='Ошибка во время обращения к протоколу!';
				$d['status']=500;
			}
			print $jsonencoder->encode($d);
			break;
		case '0x39':
			$result=array();
			$result['message']="Ошибка во время перевода !";
			$result['status']=0;
			$data=$tools->getEnvVars("GET",true);
			if(!$tools->checkValues($data,array("q","dest")))
			{
				$result['message']="Ошибка во время проверки данных !";
			}else
			{
				$result['message']=$googletranslate->translate($data['q'],$data['dest'],($data['source']!='')?$data['source']:null,($data['callback']!=''),$data['callback']);
				$result['status']=500;
			}
			print $jsonencoder->encode($result);
			break;
		case '0x38':
			$d=array();
			$d['message']='Произошла внутренняя ошибка';
			$d['status']=0;
			if(!isset($_GET['email']) || trim($_GET['email'])=='')
			{
				$d['message']='Ошибка во время обращения к протоколу!';
			}else
			{
				if(!$database->checkRowExists("subscribers",array("email"=>$_GET['email'])))
				{
					$q=$database->insertRow("subscribers",array("",mysql_real_escape_string($_GET['email']),"","html",time(),"on"));
					if(!$database->isError())
					{
						$d['message']='Ваш адрес успешно добавлен в списки рассылки !';
						$d['status']=1;
					}else
					{
						$d['message']='Ошибка во время добавления адреса !';
						$d['status']=500;
					}
				}else{
					$d['message']='Вы уже подписаны на нашу рассылку !';
				}
			}
			print $jsonencoder->encode($d);
			break;
		default:
			die("wrong protocol");
	}
}
?>