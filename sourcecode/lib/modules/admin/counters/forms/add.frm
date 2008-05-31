<form action='' method='post'>
	<div class='form'>
		<div class='legend'>Добавление счётчика</div>
		<div class='row'>
			<div class='label label1'>Название:</div>
			<div class='value'>
				<input type='text' name='title'/>
			</div>
		</div>
		<div class='row'>
			<div class='label label1' style='clear:both;width:100%;'>HTML-код счётчика:</div>
		</div>
		<div class='row'>
			<div class='value' style='clear:both;width:100%;'>
				<textarea name='html' rows='10' cols='65'></textarea>
			</div>
		</div>
		<div class='row'>
			<div class='label'>Включить:</div>
			<div class='value'>
				<input type='checkbox' name='status' value='on'/>
			</div>
		</div>
		<div class='row'>
			<div class='submit'>
				<input type='submit' name='action_add' value='Добавить'/>
			</div>
		</div>
	</div>
</form>
