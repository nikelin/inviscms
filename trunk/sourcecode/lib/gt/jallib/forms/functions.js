<?xml version='1.0'?>
<lib status='on'>
	<authority>
		<module>MailList Module</module>
		<description>
			<item url='http://innoweb.org.ua/docs/cms/sbm.html' lang='ru'>
				<!--description on russian language-->
			</item>
		</description>
		<author>Kirill Karpenko aka Nikelin</author>
		<company>InnoWeb Studio</company>
		<reply-to>LoRd1990@gmail.com</reply-to>
		<license>InnoWeb EULA</license>
		<license-url>http://innoweb.org.ua/licenses/eula.txt</license-url>
		<published>2008.03.02</published>
		<version>1.0.1</version>
		<regcode>IEM-2010-02</regcode>
		<protect>
			<md5>{md5_hash}</md5>
			<openpgp>
			</openpgp>
		</protect>
	</authority>
	<data>
		<methods>
			<item name='form_registered'>
				<vars>
					<var name='frm' important='true'/>
					<var name='data' important='true'/>
				</vars>
				<implementation>
				<![CDATA[
						if(this.form_registered(frm) && typeof(data)=="object"){
							this.frm_fields.push({frm_id:frm,name:data['name'],label:data['label'],type:data['type'],imp:data['imp'],ml:data['ml']});
						}
				]]>
				</implementation>
			</item>
			<item name='form_registered'>
				<vars>
					<var name='id' important='true'/>
				</vars>
				<implementation>
				<![CDATA[
						for(var i in this.frms)
						{
							if(this.frms[i]['name']==id) return true;
						}
						return false;
				]]>
				</implementation>
			</item>
		</methods>
	</data>
</lib>


	: function()
	{
		//alert(frm);
		
	},
	form_reg: function(id,els_count)
	{
		this.frms.push({name:id,els_count:els_count});
		return (this.frms.length-1);
	},
	form_get_fields: function(id){
		var result=[];
		for(var i in this.frm_fields)
		{
			if(this.frm_fields[i]['frm_id']==id) result.push(this.frm_fields[i]);
		}
		return result;
	},
	form_info: function(id)
	{
		for(var i in this.frms)
		{
			if(this.frms[i]['name']==id) return this.frms[i];
		}
		return null;
	},
	form_proceed:function(id,cb){
		var result=[];
		if(this.form_registered(id)){
			var elems=this.form_get_fields(id);
			var form=this.form_info(id);
			var mfields=document.getElementById(id).elements;
			if(mfields.length!=form.els_count)
			{
				alert("ошибка во время проверки формы!");
				return false;
			}else{
				for(var i in elems)
				{
					if(elems[i].imp)
					{
						if (mfields[elems[i].name].length == 0) {
							alert("вы не заполнили обязательное поле: " + elems[i]['label']);
							return false;
						}
						else {
							if(elems[i].type=='number')
							{
								if(!Invis.core.isNumber(mfields[elems[i].name])){
									alert("Неправильный формат данных!");
									break;
								}
							}
							if (elems[i].ml >= mfields[elems[i].name].length) {
								alert("минимальное количество символов строки:"+elems[i]['label']+" "+elems[i].ml)
								return false;
							}else{
								result.push({name:elems[i].name,value:mfields[elems[i].name].value});
							}
						}
					}else{
						result.push({name:elems[i].name,value:mfields[elems[i].name].value});
					}
				}
			}
		}else{
			return false;
		}
		alert('Проверка прошла успешно ! Отправляем данные на сервер...');
		if (!Invis.core.xhttp.isA()) {
			Invis.core.xhttp._send(Invis.getPath() + '/dx.php?x=0x21&frm_name=' + id + '&result=' + JSON.stringify(result), cb, 'text');
		}else{
			window.location.href="/proceed/"+id+"/"+encode64(result);
		}
		return false;
	},