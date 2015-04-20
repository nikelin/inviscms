# Обзор #

Данная библиотека является частью поставляемой вместе с основной платформой Invis библиотеки InvisCore JS, и реализует функции динамической подгрузки JavaScript-методов, оформленных в формате JAL. Для подгрузки используется технология Ajax, а так же внутренние возможности обработки XML платформы реализации JavaScript-языка.

# Подробности #

JAL пакет является XML-документом, который описывает JavaScript методы, которые должны быть импортированы в динамическую среду, и носит так же спецификационный характер, всё с той же целью унификации и стандартизации.

Структура некоторого пакета JAL:
```
--- somepackage
  --- part.jal
```

Пример **JavaScript ActiveLibrary** пакета:
```
<?xml version='1.0' encoding='utf-8'?>
<lib status='on'>
      <authority>
            <module>Shop Basket Module</module>
	    <description>
		<item url='http://innoweb.org.ua/docs/cms/sbm.html' xml:lang='ru'>
			<!--description on russian language-->
		</item>
	    </description>
	    <author>Kirill Karpenko aka Nikelin</author>
	    <company>InnoWeb Studio</company>
	    <reply-to>LoRd1990@gmail.com</reply-to>
	    <license>InnoWeb EULA</license>
	    <license-url>http://innoweb.org.ua/licenses/eula.txt</license-url>
	    <pubdate>2008.03.02</pubdate>
	    <version>1.0.1</version>
	    <regcode>AB52CBF27</regcode>
	    <protect>
		<md5>{md5_hash}</md5>
	    </protect>
	</authority>
	<data>
	   <methods>
		<item name='_proceed'>
		     <vars>
			<var name='data' type='numeric' important='true'/>
		     </vars>
		     <implementation>
		     <![CDATA[
			// Function implementation code
                        // Compitable with ECMAScript v.3
		     ]]>
		     </implementation>
		</item>
		<item name='plus'>
		     <vars>
			<var name='id' important='true'/>
		     </vars>
		     <implementation>
		     <![CDATA[
			 alert("Please wait for a few seconds...");
		     ]]>
		     </implementation>
		</item>
	    </methods>
        </data>
</lib>
```

Для подгрузки библиотеки в динамическую среду необходимо вызвать функцию:
```
     Invis.modules.loadLib("somelib","somepart");
```

После чего в структуре Invis.modules.store создаётся новый элемент с идентификатором `somelib`, и в него будут подгружены все декларации методов из ./somelib/somepart.jal.

Когда обработка метода завершается, к новосозданной структуре будет добавлен новый элемент с идентификатором, идентичным идентификатору декларируемого метода, в которую добавляется объект ECMAScript типа "функция" и текст тела метода. Далее приведена спецификация элемента структуры Invis.modules.store.{%some\_module%}.{%some\_method%}:
```
Invis.modules.store.{%some_module%}.{%some_method%}={
   'kick': function(args[,args_list]*),
    'implementation': 'method implementation'
}
```