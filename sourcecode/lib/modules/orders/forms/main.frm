<form action='' method='post'>
	<div class='table' style='clear:both;'>
		<h2 class='title'>Поступившие заказы</h2>
		<div class='header'>
			<div class='row'>
				<div class='col' style='width:5%;'>#</div>
				<div class='col' style='width:15%;'>Сектор</div>
				<div class='col' style='width:15%;'>Сумма</div>
				<div class='col' style='width:15%;'>Клиент</div>
				<div class='col' style='width:15%;'>Дата</div>
				<div class='col' style='width:15%;'>Состав</div>
				<div class='col' style='width:10%;'>&nbsp;</div>
			</div>
		</div>
		<div class='body'>
		<?php
		$q=$database->proceedQuery("
							SELECT 
									#prefix#_orders.id AS id,
									#prefix#_client.name AS client,
									#prefix#_orders.products AS pl,
									#prefix#_orders.date AS date,
									#prefix#_orders.summ AS summ,
									#prefix#_orders.sector AS sector,
									#prefix#_orders.status AS status
							FROM	#prefix#_orders, #prefix#_clients
							WHERE	#prefix#_clients.id=#prefix#_orders.client
									OR #prefix#_clients.ip=#prefix#_orders.client
							ORDER by #prefix#_clients.id ASC
								");
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				while($row=$database->fetchQuery($q))
				{
					?>
					<div class='row'>
						<div class='col'>
							<input type='checkbox' name='els[]'/>
						</div>
						<div class='col'>#<?=$row['id'];?></div>
						<div class='col'><?=$row['sector'];?></div>
						<div class='col'><?=$row['summ'];?></div>
						<div class='col'><?=$row['client'];?></div>
						<div class='col'><?=$row['date'];?></div>
						<div class='col'>
							<button>view</button>
						</div>
						<div class='col'>
							<button>close</button>
							<button>delete</button>
						</div>
					</div>
					<?php
				}
			}else
			{
				?>
				<div class='row'>
					<div class='col' style='clear:both;width:100%;'><strong>Заказы ещё не поступили...</strong></div>
				</div>
				<?
			}
		}else
		{
			?>
			<div class='row'>
				<div class='col' style='clear:both;width:100%;'>Заказы ещё не поступили...</div>
			</div>
			<?
		}
		?>
		</div>
	</div>
</form>