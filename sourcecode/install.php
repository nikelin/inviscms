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
 include "./lib/core/others/globals.php";
 include "./lib/core/interfaces/system/interfaces.system.php";
 include "./lib/core/packages/system/package.system.php";
 $system=new system();
 $system->setPath('packages','./lib/core/packages');
 $system->setPath('interfaces','./lib/core/interfaces');
 $system->setPath('abstractions','./lib/core/abstractions');
 $system->setPath('errors','./lib/core/errors');
 $system->registerPackage("tools");
 $system->registerPackage("errors");
 $system->registerPackage("security");
 $system->loadLibs();
 $errorB=new errors();
 if(isset($_POST['install'])){
  $data=$tools->getEnvVars('POST');
  if(!$tools->checkValues($data,array('dbhost','dbuser','dbname'))){
	 $errorB->appendJSError("Wrong database name of you haven't rights to access choosen database.");
  }else{
	  $conn=mysql_connect($data['dbhost'],$data['dbuser'],$data['dbpasswd']);
	  if(!$conn){
		 $errorB->appendJSError("Database connection error...");
	  }else{
		 if(!mysql_select_db($data['dbname'])){
			 $errorB->appendJSError("Wrong database selecting error.");
		 }else{
			 if(!($fp=@fopen($system->getPath('packages').'/database/config.xml','w+')))
			 {
			  $errorB->appendJSError("System path wrong or you haven't rights to write !");
			 }else{
				$toWrite='<?xml version="1.0"?>'."\n";
				$toWrite.="<config>"."\n";
				$toWrite.="	<param name='dbhost' value='".$data['dbhost']."'/>"."\n\r";
				$toWrite.="	<param name='dbuser' value='".$data['dbuser']."'/>"."\n\r";
				$toWrite.="	<param name='dbpasswd' value='".$data['dbpasswd']."'/>"."\n\r";
				$toWrite.="	<param name='dbname' value='".$data['dbname']."'/>"."\n\r";
            	$toWrite.="<param name='prefix' value='".$data['prefix']."'/>"."\n\r";
				$toWrite.="</config>";
				if(!fwrite($fp,$security->encr($toWrite,"dasdasdvdst23tgeb"))){
				  $errorB->appendJSError("Configuration information writing error !");
				}else{
				  $errorB->appendJSError("Database information was successfully saved !");
				  $errorB->appendJSError("Try to write other system information...");
				  if(!($fp2=fopen($data['syspath'].'/config.xml','w+'))){
					  $errorB->appendJSError("System path wrong or you haven't rights to write !");
				  }else{
					 $toWrite='<?xml version="1.0"?>';
					 $toWrite.='<config>';
					 $toWrite.='<param name="syspath" value="'.$data['syspath'].'"/>';
					 $toWrite.='</config>';
					 if(!fwrite($fp2,$toWrite)){
						$errorB->appendJSError("System configuration information writing error !");
					 }else{
						$errorB->appendJSError("Installation successful !");
					 	$errorB->redirect("/index.php");
					 }
				  }
				}
			 }
		 }
	  }
  }
 }
?>
<html>
 <head>
       <title>Installation in process...</title>
       <link rel='stylesheet' href='./lib/gt/admin.css'/>
       <?=$errorB->outputData();?>
 </head>
 <body>
 <h1>InvisibleSystems InvisCore <span style='color:#FF0000;'>0.5A</span></h1>
		<form action='' method='post'>
			<div class='form'>
				<div class='legend center' style='width:100%;clear:both;'>System configuration</div>
				<div class='row'>
						<span class='label'>
								Enter path to system folder:
						</span>
						<span class='value'>
							  <input type='text' name='syspath' value='<?=$_SERVER['DOCUMENT_ROOT'];?>'/>
				      </span>
				</div>
				<div class='legend center' style='width:100%;clear:both;'>Database configuration</div>
				<div class='row'>
						<span class='label'>
								Enter database host:
						</span>
						<span class='value'>
							  <input type='text' name='dbhost' value='localhost'/>
				      </span>
				</div>
				<div class='row'>
						<span class='label'>
								Enter database user:
						</span>
						<span class='value'>
							  <input type='text' name='dbuser' value='root'/>
				      </span>
				</div>
				<div class='row'>
						<span class='label'>
								Enter database password:
						</span>
						<span class='value'>
							  <input type='text' name='dbpasswd'/>
				      </span>
				</div>
			 	<div class='row'>
						<span class='label'>
								Enter name of database to store information:
						</span>
						<span class='value'>
							  <input type='text' name='dbname' value='futbolka'/>
				      </span>
				</div>
				<div class='row'>
						<span class='label'>
								Enter table prefix:
						</span>
						<span class='value'>
							  <input type='text' name='prefix'/>
				      </span>
				</div>
				<div class='row'>
					<span class='label center' style='width:100%;clear:both'>SMTP-server settings</span>
				</div>
				<div class='row'>
						<span class='label'>
								SMTP-host:
						</span>
						<span class='value'>
							  <input type='text' name='smtp_host'/>
				      </span>
				</div>
				<div class='row'>
						<span class='label'>
								SMTP-port:
						</span>
						<span class='value'>
							  <input type='text' name='smtp_port'/>
				      </span>
				</div>
				<div class='row'>
						<span class='label'>
								User login:
						</span>
						<span class='value'>
							  <input type='text' name='smtp_login'/>
				      </span>
				</div>
				<div class='row'>
						<span class='label'>
								User password:
						</span>
						<span class='value'>
							  <input type='text' name='smtp_passwd'/>
				      </span>
				</div>
				<div class='submit center'>
					  <input type='submit' style='width:100%;' name='install' value='Install'/>
				</div>
			</div>
		</form>
	</body>
</html>
