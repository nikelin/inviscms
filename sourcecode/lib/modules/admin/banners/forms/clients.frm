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
$errorsB=new Errors();
?>
<form action='' method='post' id='main'>
    <div class='dT'>
        <span class='header'>Управление пользователями баннерной системы</span>
        <div class='body'>
            <div class='header'>
                <span class='col' style='width:5%;'>#</span>
                <span class='col' style='width:20%;'>Клиент</span>
                <span class='col' style='width:20%;'>E-mail</span>
                <span class='col' style='width:20%;'>Дата регистрации</span>
                <span class='col' style='width:10%;'>Кол. баннеров</span>
                <span class='col' style='width:20%;'>Действия</span>
            </div>
            <?php
			 $q=$database->proceedQuery("SELECT
			 								#prefix#_accounts.name AS fio,
											#prefix#_clients.email AS email,
											#prefix#_accounts.laccess AS date,
											COUNT(#prefix#_banners.id) AS banners
											FROM `#prefix#_banners`,`#prefix#_clients`,`#prefix#_accounts`
											WHERE 
												#prefix#_accounts.pid=#prefix#_clients.id
												AND #prefix#_clients.id=#prefix#_banners.client
											GROUP by `#prefix#_clients.id`
											ORDER by `#prefix#_client.id ASC");
						#die_r($database->sqlErrorString());
			 if($database->isError()){
           	 	$errorsB->appendJSError("Ошибка во время диалога с БД !");
				?>
            <div class='row'>
                <span class='col' style='width:100%;'>Ошибка во время диалога с БД!</span>
            </div>
            <?php
			 }else{
			  if($database->getNumrows($q)!=0){
				 while($row=$database->fetchQuery($q)){
			 	 ?>
            <div class='row'>
                <span class='col' style='width:5%;'>
                	<input type='checkbox' name='ids[]' value='<?=$row['id'];?>'/>
				</span>
				<span class='col' style='width:20%;background-color:#<?=(($row['status']!='on')?"FF0000":"00AA00");?>'>
                    <?=rawurldecode($row['fio']);?>
                </span>
                <span class='col' style='width:20%;'>
                    <?=rawurldecode($row['email']);?>
                </span>
                <span class='col' style='width:20%;'>
                    <?=date("d.m.Y",$row['date']);?>
                </span>
                <span class='col' style='width:10%;'>
                    <?=$row['banners'];?>
                </span>
                <span class='col' style='width:20%;'>
                    <button style='width:100px;height:20px;font-size:10px;' onclick='Invis.core.loadPage("clients","edit/<?=$row['id'];?>");return false;'>
						INFO
                    </button>
                </span>
            </div>
            <?php
		  		 }
			 }else{
				?>
            <div class='row'>
                <span class='col' style='width:100%;'>Информация не найдена.</span>
            </div>
            <?php
			 }
		 }
			 ?>
            <input type='hidden' name='action_clients'/>
            <div class='row'>
                <div class='col' style='width:100%;background-color:#000000;'>
                    <button onclick="Invis.core.loadPage('banners','clientsadd');return false;">
                        Добавить клиента
                    </button>
                </div>
            </div>
        </div>
    </div>
  </form>
<?php
print $errorsB->outputData();
?>
