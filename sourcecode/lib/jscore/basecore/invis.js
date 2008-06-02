/**
* @package InvisCore JavaScript Engine
* @author K.Karpenko aka LoRd
*/

Function.prototype.bind = function(obj) { 
  var method = this;
  var obj=obj;
  var args=arguments;
   temp = function() {
    return method.apply(obj, args); 
   }; 
  return temp; 
 }

function Invis()
{
  this.constructor=new Object();
  this.onl=null;
  this.browser={
			    IE:!!(window.attachEvent && !window.opera),
			    Opera:  !!window.opera,
			    WebKit: navigator.userAgent.indexOf('AppleWebKit/') > -1,
			    Gecko:  navigator.userAgent.indexOf('Gecko') > -1 && navigator.userAgent.indexOf('KHTML') == -1,
			    MobileSafari: !!navigator.userAgent.match(/Apple.*Mobile.*Safari/)
			  };
}

Invis.prototype.getPath=function()
{
	return this.path;
}

Invis.prototype.setPath=function(path)
{
	this.path=path;
}

Invis.prototype.help={
	emailSecure: function(){
		var w=window.confirm("Вы можете не беспокоится за сохранность ваших данных!\n Мы не занимаемся продажей или разглашением ваших персональных данных, вы для нас - намного ценнее!\n\n\nС уважением, Администрация.")
	},
	submitConfirm: function(e)
	{
		var c=window.confirm("Вы хорошо проверили информацию перед тем как её отправлять ?");
		if(c){
			return true;
		}else{
			return false;
		}
	}
}


Invis.prototype.modules={
	current_data:null,
	current_path:null,
	current_module:null,
	store:{},
	setDefaultPath: function(path)
	{
		this.path=path;
	},
	getPath: function()
	{
		return this.path;
	},
	call: function(funct)
	{
		setTimeout(function(){funct()},10);
	},	
	loadProceed: function(r)
	{return 1;
		//this.cb='dasd';
		this.current_data=r;
		var root=this.current_data.firstChild;
		if (root) {
			if (root.attributes.status.nodeValue == 'on') {
				var authority = root.getElementsByTagName("authority")[0];
				var data = root.getElementsByTagName("data")[0];
				var methods = data.getElementsByTagName("methods")[0];
				var it = methods.getElementsByTagName("item");
				this.store[this.current_module] = {};
				for (var i = 0; i < it.length; i++) {
					var func = it[i].attributes.item(0).nodeValue;
					this.store[this.current_module][func] = {};
					var code = it[i].getElementsByTagName('implementation')[0];
					var implementation = (Invis.browser.Opera)?code.text:code.textContent;
					var args = it[i].getElementsByTagName('vars')[0];
					var arg = args.getElementsByTagName('var');
					var params = [];
					for (var j = 0; j < arg.length; j++) {
						params.push(arg[j].attributes.name.nodeValue);
					}
					this.store[this.current_module][func]['kick'] = new Function(params, implementation);
					this.store[this.current_module][func]['code'] = {
						args: params,
						body: implementation
					};
				}
			}
			else {
				alert("Данная библиотека заблокирована!");
			}
		}else
		{
			alert("Ошибка формата файла!");
		}
		return this.store[this.current_module];
	},
	loadInit: function(module,pack)
	{
		if(module!='')
		{
			this.current_module=module;
			this.current_part=pack;
			Invis.core.xhttp._send(Invis.getPath()+'/dx.php?x=0x32&m='+module+'&p='+pack,Invis.modules.loadProceed,"xml",false);
		}else{
			alert("Не введён идентификатор библиотеки!");
		}
	}
};


Invis.prototype.core={
	/**
	*
	* @param {Array} array
	* @param {String} str
	*/
	isArray:function(e)
	{
		return(typeof(e)=="Object");
	},
	isURI: function(e){
		if(this.isString(e) && !this.empty(e)){
			if(this.isURL(e)){
				return true;
			}else{
				return e.match('^[\/]*[\?]*[a-zA-Z0-9_\-\%\&\?\.;,\[\]\{\}\\]{1,}$');
			}
		}
		return null;
	},
	loadPage:function(module,act){
		window.location.href="/admin/"+module+"/"+act;
	},
	isNumber: function(e){
		return(typeof(e)=="Number")
	},
	isRawEncoded: function(e){
		return (e.match('([%]+[a-fA-F0-9\=]{2,2}){1,}'));
	},
	isURL: function(e){
		return (e.match('^(http:\/\/)?(www\.)*([a-zA-Z0-9_]*(\.)+){2,}[\/]*'))
	},
	isString: function(e){
		return (typeof(e)=="string");
	},
	isRawEncoded: function(e){
		return (e.match('([%]+[a-fA-F0-9\=]{2,2}){1,}'));
	},
	rawEncode: function(e){
		if(this.isArray(e)){
			for(i in e){
				if(!this.isArray(e[i])){
					e[i]=encodeURIComponent(e[i]);
				}else{
					e[i]=this.rawEncode(e[i]);
				}
			}
		}else if(this.isString(e)){
			e=encodeURIComponent(e);
		}
		return e;
	},
	rawDecode: function(e){
		if(this.isArray(e)){
			for(i in e){
				if(!this.isArray(e[i])){
					while (!this.isRawEncoded(e[i])) {
						e[i] = decodeURIComponent(e[i]);
					}
				}else{
					e[i]=this.rawDecodeArray(e[i]);
				}
			}
		}else if(this.isString(e) && !this.empty(e)){
			while(!this.isRawEncoded(e)){
				e=decodeURIComponent(e);
			}
		}
		return e;
	},
	empty: function(e){
		if(this.isString(e)){
			while(e.length>0 && (e[0]=" " || e[e.length-1]==" ")){
				if(e[0]==" "){
					e.substr(1,e.length-1);
				}else if(e[length-1]==" "){
					e.substr(0,e.length-2);
				}
			}
			return (e.length==0);
		}else if(this.isArray(e)){
			var empty=0;
			for(var i=0;i<e.length;i++){
				if(this.empty(e[i])){
					empty++;
				}
			}
			return (empty==e.length);
		}else if(this.isNumber(e)){
			return (e==0);
		}
		return null;
	},
	cut: function(array, start, end){
		var returnArray=[array[start]];
		var piece=(end<0)?array.length+end:end;
		var i=start;
		for(i+=1;i<piece;i++){
			returnArray.push(array[i]);
		}
		return returnArray;
	},
	cutByType: function(array, type){
		var returnArray=[];
		for(i in array){
			if(this.isArray(array[i])){
				returnArray.push(this.cutByType(array[i],type));
			}else{
				if(typeof(array[i])==type){
					returnArray.push(array[i]);
				}
			}
		}
		return returnArray;
	},
	addEventListener: function(el, evnt, func){
	   if (el.addEventListener) {
	      el.addEventListener(evnt.substr(2).toLowerCase(), func, false);
	   } else if (el.attachEvent) {
	      el.attachEvent(evnt, func);
	   } else {
	      el[evnt] = func
	   }
	},
	createCollection: function(array,step){
		var returnCollection={};
		if(this.isArray(array) && this.isNumber(step)){
			if(step>this.length)return [];
			for(i in this){
				if(i%step==0){
					returnCollection.$(this[i])=(step)?'':new Array();
				}else{
					lastMatch=array[i-i%step];
					if(this.isObject(lastMatch)){
						returnCollection.$(lastMatch).push(this[i]);
					}else{
						returnCollection.$(lastMatch)=this[i];
					}
				}
			}
		}
		return returnCollection;
	},
	getAllX: function(array,step){
		var returnArray=[];
		if (this.isArray(array) && this.isNumber(step)) {
			if (step > this.length)
			return [];
			for (i in this) {
				if (this[i] && i % step == 0) {
					returnArray.push(this[i]);
				}
			}
		}
		return returnArray;
	},
	cutEmpty: function(array){
		var returnArray=[];
		if (this.isArray(array)) {
			for (i in array) {
				if (!this.isArray(array[i])) {
					if (array.isString(array[i]) && !this.empty(array[i])) {
						returnArray.push(array[i]);
					}
				}
				else {
					returnArray.push(this.cutEmpty(array[i]));
				}
			}
		}
		return returnArray;
	},
	find: function(array,e)
	{
		for(i in array)
		{
				if(array[i]==e)return i;
		}
		return false;
	},
	find_rc2: function(array,str){
		var returnArray = null;
		if (this.isString(str) && this.isArray(array)) {
			for (i = 0; i < array.length; i++) {
				if (!this.isArray(array[i])) {
					if (this.isMethod(str)) {
						if (searchStr.test(array[i])) {
							if (!returnArray) {
								returnArray = new Array()
							}
							returnArray.push(i);
						}
					}
					else {
						if (array[i] === searchStr) {
							if (!returnArray) {
								returnArray = []
							}
							returnArray.push(i);
						}
					}
				}
				else {
					return this.find(array[i], str);
				}
			}
		}
		return returnArray;
	},
	isMethod: function(e){
		return (typeof(e)=='function');
	},
	isHEX: function(e){
		return (e.match('[a-fA-F0-9]'));
	},
	isColor: function(e){
		if(this.isString(e)){
			if(!this.empty(e)){
				e=(e[0]=='#')?e.substr(1,e.length-1):e;
				return (e.length>2 && e.length<6 && this.isHEX(e));
			}else{
				return false;
			}
		}else if(this.isArray(e)){
			var colors=new Array();
			for(var i=0;i<e.length;i++){
				if(this.isColor(e[i])){
					colors++;
				}
			}
			return colors;
		}else if(this.isNumber(e)){
			return (e.length>2 && e.length<6);
		}
		return null;
	},
	inHash: function(hash,el)
	{
		for(i in hash)
		{
			if(typeof(i)=="Array")
				return this.inHash(hash[i],el);
			else{
				if(hash[i]==el) return true;
			}
		}
	},
	inArray: function(e, array,dem)
	{
		var currDepth=1;
		if (this.isArray(array) && !this.empty(array))
		{
			for (var i = 0; i < array.length; i++)
			{
				if (this.isArray(array[i]) && currDepth<dem)
				{

					currDepth++;
					return (this.inArray(e, array[i]));
				}
				else {
					if (e == array[i]) {
						return true;
					}
				}
			}
			return false;
		}
		else {
			return false;
		}
	},
	fillArray:function (array,fill){
		for(var i=0;i<array.length;i++){
			array[i]=fill;
		}
		return array;
	},
	isArray: function(e)
	{
		return (e instanceof Array);
	},
	isString: function(e)
	{
		return (e instanceof String);
	}
};

Invis.prototype.tools={
	libs: [],
	frms: [],
	frm_fields: [],
	setLang:function(value){
		document.cookie="lang="+value;
		return true;
	},
	form_registered: function(id){
		for(var i in this.frms)
		{
			if(this.frms[i]['name']==id) return true;
		}
		return false;
	},
	form_append_field: function(frm,data)
	{
		//alert(frm);
		if(this.form_registered(frm) && typeof(data)=="object"){
			this.frm_fields.push({frm_id:frm,name:data['name'],label:data['label'],type:data['type'],imp:data['imp'],ml:data['ml']});
		}
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
	form_objects_draw:function(id)
	{
	  var el=document.createElement("div");
	  el.setAttribute("id",id);
	  for(var i=0;i<this.frms.length;i++)
	  {
	    el.innerHTML+='<form action="" method="post" id="'+this.frms[i]['name']+'"></form>';
	  }
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
	loadLib: function(type,src,place,after_load){
	  switch(type){
	      case 'css':
				var lib=document.createElement('link');
				lib.setAttribute('href',src);
				lib.setAttribute('rel','stylesheet');
				lib.setAttribute('type','text/css');
				lib.setAttribute('media','all');
				lib.disabled=false;
				break;
	      case 'js':
	      case 'javascript':
	      default:
				var lib=document.createElement('script');
				lib.src=src;
				lib.setAttribute('type','text/javascript');
				if(after_load)
					Invis.core.addEventListener(lib,"onreadystatechange",after_load);
			break;
	  }
	  if (!place) {
		  	document.getElementById('head').appendChild(lib);	
	  }else {
	  		document.getElementById(place).appendChild(lib);
	  }
	},
	
	changeElVis:function(id,type){
		if (Invis.core.DOM.isExists(id)) {
			var el = document.getElementById(id);
			switch (type) {
				case 'on':
				el.style.display = 'block';
				break;
				case 'off':
				el.style.display = 'none';
				break;
				case 'switch':
				el.style.display = (el.style.display == 'block') ? 'none' : 'block';
				break;
				default:
				el.style.display = type;
				break;
			}
			return true;
		}else{
			return false;
		}
	},
	extractQSElement: function(query, name, glue){
		var result = '';
		glue = (glue) ? glue : ';';
		if (query.length != 0 && name.length != 0) {
			elems = query.split(glue);
			if (elems.length > 0) {
				for (var i = 0; i < (elems.length - 1); i++) {
					piece = elems[i].split('=');
					if (piece[0] == name) {
						result = piece[1];
						break;
					}
				}
			}
		}
		return result;
	}
};

Invis.prototype.tools.googletranslate={
	/**
	 * 
	 * @param {Object} text  Text to translate
	 * @param {Object} dest   Destination language
	 * @param {Object} source  Source language
	 * @param {String} callback Callback function
	 */
	translate: function(text,dest,source,context)
	{
		if (typeof(text) != "object") {
			if (text == '') {
				alert("Вы не ввели текст для перевода !")
				return 0;
			}
			if (dest == '') {
				alert("Вы не выбрали конечный язык перевода !");
				return 0;
			}
			Invis.core.xhttp._send(Invis.getPath() + '/dx.php?x=0x39&q=' + text + '&dest=' + dest + '&source=' + source + '&callback=Invis.tools.googletranslate._successful&context=' + context, Invis.tools.googletranslate.translate,"text",false);
		}else
		{
			eval(text);
		}
	},
	detect: function(text)
	{
		
	},
	_successful: function(context,object,status,details)
	{
		if (status == 200) {
			var el = document.getElementById(context);
			if (el) {
				if (el.innerHTML) {
					el.innerHTML = object['translatedText'];
				}
				else 
					if (el.value) {
						el.value = object['translatedText']
					}
			}else
			{
				alert("Задан несуществующий контекст !");
			}
		}else
		{
			alert("Ошибка во время перевода !");
		}
	}
}

Invis.prototype.tools.JSTemplater={
	vars: [],
	arrays: [],
	libs: [],
	patterns: {},
	data: '',
	init: function(){
		this.setMode('parsing');
		this.initPatterns();
		this.proceedCompilation();
		this.updatePage();
		this.setMode('finished');
	},
	setPatterns: function(){
		this.patterns.arrays="(([a-zA-Z0-9_\\-]{1,})\\{([a-zA-Z0-9_\\-]*)\\})";
		this.patterns.bracket=["\\{\\^","\\^\\}"];
		this.patterns.funct="(([a-zA-Z0-9_\\-]{1,})[\\(]+(.{1,}\\,)[\\)]+)";
		this.patterns.vars="([a-zA-Z0-9_\\-]{1,})+";
		this.patterns.loop=new Array();
		this.patterns.loop.push([
		"for[\\s]*([a-zA-Z0-9_]*)+[\\s]*from[\\s]*([0-9]*)[\\s]*to([0-9]*)",
		"/for"
		]);
		this.patterns.each=new Array();
		this.patterns.each.push([
		"iterate[\s]*([a-zA-Z0-9_]*)[\s]*as[\s]*([a-zA-Z0-9_]*)\=([a-zA-Z0-9_]*)",
		"\\/iterate"
		]);
	},
	initPatterns: function(){
		this.setPatterns()
		for(var i in this.patterns){
			if(i!='bracket'){
				var el=this.patterns[i];
				if(typeof(this.patterns[i])=='object'){
					for(j=this.patterns[i].lenght;j>0;j--){
						this.patterns[i][j]=this.patterns.bracket[0]+this.patterns[i][j]+this.patterns.bracket[1];

						this.patterns[i][j]=new RegExp(this.patterns[i][j],"gmi");
					}
				}else{
					this.patterns[i]=this.patterns.bracket[0]+this.patterns[i]+this.patterns.bracket[1];
					this.patterns[i]=new RegExp(this.patterns[i],"gmi");
				}
			}
		}
	},
	proceedCompilation: function(){
		this.data=document.getElementById('body').innerHTML;
		this.parseVariablesCalls();
		this.parseArraysCalls();
		//this.parseFunctionsCalls();
	},
	registerLib: function(src_s,type_s){
		this.libs.push({src:src_s,type:type_s});
	},
	updatePage: function(){
		//alert(this.data);
		document.getElementById('body').innerHTML=this.data;
	},
	setMode: function(status){
		switch(status){
			case 'parsing':
			document.getElementById('body').style.display='none';
			break;
			case 'finished':
			document.getElementById('body').style.display='block';
			break;
			default:
			alert('Wrong mode was setted !');
			break;
		}
	},
	assignVariable: function (name_d, value_d){
		if(!Invis.core.inArray(name_d,this.vars) && !Invis.core.empty(name_d) && !Invis.core.empty(value_d)){
			this.vars.push({name:name_d, value:value_d});
		}else{
			alert("Wrong variable definition !");
		}
	},
	varExists: function(name){
		for(var i=(this.vars.length-1);i>=0;i--){
			if(this.vars[i].name==name){
				return true;
			}
		}
	},
	arrayExists: function(name){
		for(var i=(this.arrays.length-1);i>=0;i--){
			if(this.arrays[i].name==name){
				return true;
			}
		}
	},
	arrayElemExists: function(arr,name){
		for(var i=(this.arrays.length-1);i>=0;i--){
			if(this.arrays[i].name==arr){
				for(var j=(this.arrays[i].elems.length-1);j>=0;j--){
					if(this.arrays[i].elems[j].name==name){
						return true;
					}
				}
			}
		}
	},
	makeArray: function(name_d){
		if(!Invis.core.inArray(name_d,this.arrays) && !Invis.core.empty(name_d)){
			this.arrays.push({name:name_d,elems:[]});
		}
	},
	append2Array: function(arr,value_d){
		for(var i=(this.arrays.length-1);i>=0;i--){
			if(this.arrays[i].name==arr){
				this.arrays[i].elems.push({name:(this.arrays[i].elems.length==0)?0:this.arrays[i].elems.length,value:value_d});
			}
		}
	},
	append2ArrayIndex: function(arr,index,value_d){

		for(var i=(this.arrays.length-1);i>=0;i--){
			if(this.arrays[i].name==arr){
				this.arrays[i].elems.push({name:(!index.match(/[a-zA-Z\_]*/g))?((this.arrays[i].elems.length==0)?0:this.arrays[i].elems.length-1):index,value:value_d});
				}
			}
		},
		getVariableValue: function(name){
			for(var i=(this.vars.length-1);i>=0;i--){
				if(this.vars[i].name==name){
					return this.vars[i].value;
				}
			}
		},
		parseArraysCalls: function(){
			if(this.data.length!=0){
				var msg="";
				var matches=this.data.match(this.patterns.arrays);
				for(var i=0;i<((matches)?matches.length:0);i++){
					var match=matches[i].replace(/([\-\>\^\[\]\\'\\"])*/g,'');
					var elName='';
					var totalLEngth=0;
					var arrName='';
					match=match.slice(1,match.length-1);
					arrName=match.slice(0,match.search('{'));
					elName=match.slice(match.search('{')+1,(match.search('}')-(match.length)));
					if(this.arrayExists(arrName) && this.arrayElemExists(arrName,elName)){
						this.data=this.data.replace('{^'+arrName+'{'+elName+'}^}',this.getArrayElemValue(arrName,elName));
					}
				}
			}
		},
		getArrayElemValue: function(arr,elem){
			for(var i=(this.arrays.length-1);i>=0;i--){
				if(this.arrays[i].name==arr){
					for(var j=(this.arrays[i].elems.length-1);j>=0;j--){
						if(this.arrays[i].elems[j].name==elem){
							return this.arrays[i].elems[j].value;
						}
					}
				}
			}
		},
		parseFunctionsCalls: function(){
			if(this.data.length!=''){
				var msg="";
				var matches=this.data.match(this.patterns.funct);
				for(var i=0;i<matches.length;i++){
					var match=matches[i].replace(/([\^\{\}\[\]])*/g,'');
					this.data=this.data.replace('{^'+match+'^}',eval(match));
					break;
				}
			}
		},
		parseVariablesCalls: function(){
		  //alert('das');
			if(this.data.length!=0){
				var msg="";
				var matches=this.data.match(this.patterns.vars);
				for(var i=0;i<((matches)?matches.length:0);i++){
					match=matches[i].replace(/([\^\{\}\[\]])*/g,'');
					if(this.varExists(match)){
						this.data=this.data.replace('{^'+match+'^}',this.getVariableValue(match));
					}
				}
			}
		},
		replaceLoopCalls: function(){
		},
		replaceForeachCalls: function(){
		}
	};

	Invis.prototype.core.xhttp={
		recieved:null,
		_x:null,
		debug: true,
		cb:null,
		isA: function(){
			var x=null;
			if(false===(x=new XMLHttpRequest())){
				for(var i in this._mslibs){
				x=new ActiveXObject(this._mslibs[i]);
				if(x)break;
				}
			}
			//FIX
			return (x==true);
		},
		/**
		 * 
		 * @param {String} Destination URL-address
		 * @param {Object} Callback function 
		 * @param {String} Type of resulted string
		 * @param {Bool} Assynchronouse mode (default=true)
		 */
		_send: function(where,cb,type,recieved)
		{
			this._x=null;
			this.type=type;
			this.cb=cb;
			var progIDs=["msxml2.XMLHttp.5.0","msxml2.XMLHttp.4.0","msxml2.XMLHttp.3.0","msxml2.XMLHttp","Microsoft.XMLHttp"]; 
			if (!Invis.browser.IE) {
				this._x = new XMLHttpRequest();
			}else
			{
				for(var currentProgID = 0;currentProgID < progIDs.length;currentProgID++) {     
					try{ 
						this._x = new ActiveXobject(progIDs[currentProgID]); 
					}            
					catch(ex){}  
					if(this._x) break;
				}
			}
			if(this._x!=null){
				if(this._x.readyState==0 || this._x.readyState==4){
					this._x.open('GET',where,false);
					this._x.onload=this._proceed.bind(this);
					this._x.send(null);
				}
			}
		},
		_ready: function()
		{
			var cb=this.cb;
			var x=this._x;
			var type=this.type;
			if (!type || type == "xml")
			{
				if(cb!=null){
					return cb.call(Invis.modules,x.responseXML);
				}else
				{
					Invis.prototype.ajaxRecieve=x.responseXML;
				}
			}else{
				if(cb!=null){
					return cb.call(Invis.modules,x.responseText);
				}else{
					Invis.prototype.ajaxRecieve=x.responseText;
				}
			}
		},
		_proceed: function()
		{
			var type=this.type;
			var cb=this.cb;
			var x=this._x;
			if(x.readyState==4){
				if (x.status == 200) {
					return this._ready();
					//Invis.tools.setLoadingProgress(false);
				}
			}else{
				//Invis.tools.setLoadingProgress(true);
			}
			return false;
		}
	}
	
	Invis.prototype.tools.tabs=
	{
		tabs:{},
		addTab: function(id)
		{
			if(!this.isset(this.tabs,id) && document.getElementById(id))
			{
				this.tabs.push({
					'id': id,
					'data': null
				});
			}
			return this.tabs.length;
		},
		isset: function(id)
		{
			return Invis.core.inHash(this.tabs,id);
		},
		setTabData: function(id,data)
		{
			if(this.isset(this.tabs,id))
			{
				this.tabs[id]['data']=data;	
			}
		},
		loadExternalData: function(id,path)
		{
			//
		},
		getTabById: function(id)
		{
			for(i in this.tabs)
			{
				if(this.tabs[i]['id']==id) return true;
			}
			return false;
		},
	    showTab: function(e){
	        var el = this.getTabById(e);
	        if (el) {
	            document.getElementById(this.tabs[el]).style.display = 'block';
	            for (i in tabs) {
	                if (i != el) {
	                    document.getElementById(tabs[i]).style.display = 'none';
	                }
	            }
	        }
	    }
	}

	Invis.prototype.core.DOM=
	{
		iEls: ['HTMLInputElement','HTMLTextArea','HTMLSelectElement','HTMLCheckBoxElement','HTMLRadioElement'],
		makeNode: function(node,attrs){
			var obj=document.createElement(node);
			for(i in attrs){
				obj.setAttribute(i,attrs[i]);
			}
		},
		isExists: function(e){
		  if(Invis.core.isObject(e) || false!==(document.getElementById(e))) return true;
		},
		getObject: function(e)
		{
			if (this.isExists(e))
			{
				if (Invis.core.isString(e))
				{
					return document.getElementById(e);
				}else
				{
					return e;
				}
			}else
			{
				return;
			}
		},
		changeColor: function(id,color){
			if (this.isExists(id) && Invis.core.isColor(color)) {
				var el = Invis.core.getOBject(id);
				el.style.backgroundColor = color[0];
				el.style.color = color[1];
			}else{
				return false;
			}
		},
		appendChildToArray:function appendChildToArray(array,fill){
			if (Invis.core.isExists(fill)) {
				for (var i = 0; i < array.length; i++) {
					if (Invis.core.isExists(array[i])) {
						Invis.core.getObject(array[i]).appendChild(this.getObject(fill));
					}
				}
			}
			return array;
		},
		/**
		* Fill all elements in $elem-array with attributes from $attr-array
		* @param {Array} elem
		* @param {Array} attr
		*/
		fillWithAttribute:function(elem,attr){
			if(Invis.core.isArray(elem) && !Invis.core.empty(elem))
			{
				for(var i=0;i<elem.length;i++)
				{
					if (Invis.core.isExists(elem[i])) {
						if (Invis.core.isArray(attr) && attr.length != 0) {
							for (var j = 0; j < attr.length; i++) {
								Invis.core.getObject(elem[i]).setAttribute(array[i]['name'], array[i]['value']);
							}
						}
					}
				}
			}
			return elem;
		},
		/**
		* Set $e element to editable mode
		* @param {Object} e
		*/
		setNodeEditable: function(e){
			if (Invis.core.isExists(e)) {
				var el = Invis.core.getObject(e);
				var field = null;
				if (!this.isInput()) {
					var field=Invis.core.makeNode('HTMLInputElement',{
					'type':'text',
					'name':this.getParent(el),
					'value':el.firstChild.nodeValue
					});
					el.replaceChild(field, el.firstChild);
				}
				else {
					el.firstChild.select();
				}
				if (typeof arguments[arguments.length - 1] == 'object') {
					var app = arguments[arguments.length - 1];
					changeElVis(app[0], app[1]);
				}
			}
		},
		/**
		* Select all elements in DOM-model which have ids equals $id
		* @param {Object} id
		*/
		selectAll: function(id){
			var id=id+'[]';
			var elem=document.getElementsByTagName('input');
			for(var i=0;i<elem.length;i++){
				if(elem[i].name==id){
					if(elem[i].checked){
						elem[i].checked=false;
					}else{
						elem[i].checked=true;
					}
				}
			}
		},
		/**
		* Get values of all elements of the form with id=$id
		* @param {Object} id
		*/
		getFormValues: function(id){
			var result = false;
			if (this.isExists(id)) {
				var el = this.getObject(id);
				if (this.hasProp(el, 'elements')) {
					elems = el.elements;
					if (elems.length > 0) {
						for (var i = 0; i < (elems.length - 1); i++) {
							result += elems[i].name + '=' + encodeURIComponent(elems[i].value) + (((elems.length - 1) != i || elems.length == 1) ? ';' : '');
						}
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		},
		/**
		* Write data to specified destination
		* @param {Object} wnd
		* @param {Object} container
		* @param {String} data
		*/
		write: function(wnd, container, data)
		{
			var w=null;
			var c=null;
			if(this.isExists(wnd) && Invis.core.DOM.parent(new Window(),w)){
				w=this.getObject(wnd);
				if(container && this.isExists(container) && Invis.core.DOM.parent(w,this.getObject(container)) && Invis.core.DOM.haveProp(this.getObject(container),'innerHTML')){
					var c=this.getObject(container);
					w.c.innerHTML=(Invis.core.isString(data)?data:data.toString());
				}else{
					w.document.write(data);
				}
			}
		},
		haveProp: function(e,prop){
			//Check that e-element have prop-property
		},

		//{{!!FINISH!!}}//
		/**
		* Append new event handler to the eId element
		* @param {Object|Number} eId
		* @param {String} action
		* @param {Object} cbfunction
		*/
		addEvent: function(eId,action,rules){
			if(this.isExists(eId)){
				var el=this.getObject(eId);
				el.addEventListener(action,function(event) { return((typeof(rules)=="object")?rules():eval(rules)); },true);
			}
		},
		/**
		* Is $child the child of $parent ?
		* @param {Object} parent
		* @param {Object} child
		*/
		parent: function(parent, child){
			var p=null;
			if(this.isExists(parent) && this.isExists(child) && Invis.core.isString(child)){
				p=this.getObject(parent);
				if(p.hasChilds()){
					for(i in p.childNodes){
						if(i==child){
							return true;
						}
					}
					return false;
				}else{
					return false;
				}
			}else{
				return false;
			}
		},
		/**
		* Check that element is exists
		* @param {Object} e
		* @param {String} e
		*/
		isExists: function(e)
		{
			//return ((Invis.core.isString(e)?(document.getElementById(e)==true):(e==false)));
			return true;
		},
		/**
		* Is $e element input-class control ?
		* @param {Object} e
		*/
		isInput: function(e)
		{
			if(this.isExists(e))
			{
				return (Invis.core.inArray(e, this.iEls)!==false);
			}else{
				return false;
			}
		}
	}

	var JSON = {
		copyright: '(c)2005 JSON.org',
		license: 'http://www.crockford.com/JSON/license.html',
		stringify: function (v) {
			var a = [];

			/*
			Emit a string.
			*/
			function e(s) {
				a[a.length] = s;
			}

			/*
			Convert a value.
			*/
			function g(x) {
				var c, i, l, v;

				switch (typeof x) {
					case 'object':
					if (x) {
						if (x instanceof Array) {
							e('[');
							l = a.length;
							for (i = 0; i < x.length; i += 1) {
								v = x[i];
								if (typeof v != 'undefined' &&
								typeof v != 'function') {
									if (l < a.length) {
										e(',');
									}
									g(v);
								}
							}
							e(']');
							return;
						} else if (typeof x.valueOf == 'function') {
							e('{');
							l = a.length;
							for (i in x) {
								v = x[i];
								if (typeof v != 'undefined' &&
								typeof v != 'function' &&
								(!v || typeof v != 'object' ||
								typeof v.valueOf == 'function')) {
									if (l < a.length) {
										e(',');
									}
									g(i);
									e(':');
									g(v);
								}
							}
							return e('}');
						}
					}
					e('null');
					return;
					case 'number':
					e(isFinite(x) ? +x : 'null');
					return;
					case 'string':
					l = x.length;
					e('"');
					for (i = 0; i < l; i += 1) {
						c = x.charAt(i);
						if (c >= ' ') {
							if (c == '\\' || c == '"') {
								e('\\');
							}
							e(c);
						} else {
							switch (c) {
								case '\b':
								e('\\b');
								break;
								case '\f':
								e('\\f');
								break;
								case '\n':
								e('\\n');
								break;
								case '\r':
								e('\\r');
								break;
								case '\t':
								e('\\t');
								break;
								default:
								c = c.charCodeAt();
								e('\\u00' + Math.floor(c / 16).toString(16) +
								(c % 16).toString(16));
							}
						}
					}
					e('"');
					return;
					case 'boolean':
					e(String(x));
					return;
					default:
					e('null');
					return;
				}
			}
			g(v);
			return a.join('');
		},
		/*
		Parse a JSON text, producing a JavaScript value.
		*/
		parse: function (text) {
			return (/^(\s+|[,:{}\[\]]|"(\\["\\\/bfnrtu]|[^\x00-\x1f"\\]+)*"|-?\d+(\.\d*)?([eE][+-]?\d+)?|true|false|null)+$/.test(text)) &&
			eval('(' + text + ')');
		}
	};

	// This code was written by Tyler Akins and has been placed in the
	// public domain.  It would be nice if you left this header intact.
	// Base64 code from Tyler Akins -- http://rumkin.com

	var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

	function encode64(input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;

		do {
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output + keyStr.charAt(enc1) + keyStr.charAt(enc2) +
			keyStr.charAt(enc3) + keyStr.charAt(enc4);
		} while (i < input.length);

		return output;
	}

	function decode64(input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;

		// remove all characters that are not A-Z, a-z, 0-9, +, /, or =
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

		do {
			enc1 = keyStr.indexOf(input.charAt(i++));
			enc2 = keyStr.indexOf(input.charAt(i++));
			enc3 = keyStr.indexOf(input.charAt(i++));
			enc4 = keyStr.indexOf(input.charAt(i++));

			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;

			output = output + String.fromCharCode(chr1);

			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
		} while (i < input.length);

		return output;
	}