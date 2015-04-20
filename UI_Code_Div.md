# Обзор #

Для воплощения разделения реализации системы на "код" и "представление" применяется связка XML + XSLT.
![http://inviscms.googlecode.com/files/code-ui-div.png](http://inviscms.googlecode.com/files/code-ui-div.png)


# Детали #

## Использование wrapper-методов ##
Для реализации принципов отделения дизайна модулей от их реализации, применяется технология XML/XSL, что, в принципе, не является принципиальным.

Первым шагом в цепи генерирования контента, является запрос системой определённого части некоторого модуля, который на выходе выдаёт результаты, приемлемые для обработчика, который был привязан в качестве основного wrapper-метода для данной части модуля.

Для назначения wrapper-методов (перехватичков), целью которых является обработка некоторых данных, и последующая выдача результата опредедённого разработчиком формата.

Перехватичики служат промежуточными звеньями в процессе генерирования результатов, и могут бьть двух типов: "Глобальные" (global wrappers) и "Конкретизированные" (target wrappers).

Глобальные перехватичики применяются не к некоторому определённому модулю либо его части, а непосредственно к массиву результирующих данных, перед их непосредственной выдачей пользователю.

Локальные перехватичики назначаются либо для модуля в целом, либо для конкретной его части.

Для определения перехватичков в системе введён специальный конфигурационный файл, к которому система обращается в '/lib/configuration/wrappers.xml'. Данный файл имеет следующую спецификацию:
```
<?xml version='1.0'?>
<wrappers>
  <item id='sys_name' name='Some wrapper name (infromational)' method='methodForEVALContext'/>
</wrappers>
<globals>
  <wrapper id='sys_name' priority='0'/>
</globals>
<targets>
  <module name='system-module-name'>
     <part name='module-part'> 
        <wrapper id='sys_name' priority='0'/>
     </part>
     <part name='module-part2' wrapper='sys_name'/>
  </module>
  <module name='system-module-name2' wrapper='sys_name'/>
</targets>
```

Первым шагом являет инициализация перехватчиков, с указанием их названия (опционально, исключительно в информационных целях), идентификатора (для обращения во время назначения), а так же метода в который перехватичики будут передавать входящие данные, и результаты обработки которого выдавать на выход.

Объекты перехватчиков создаются в разделе "wrappers". После объявления перехватчиков становится доступной адресация к ним в глобальном и конкретизированном контексте.

В глобальном контексте идёт лишь перечисление перехватичиков, с указанием очереди обращения к ним, путём задания параметра приоритета вызова (priority).

Для задания конкретизации относительно некоторого модуля, либо определённого его раздела, используется привязка wrapper'ов относительно потомков от элемента tagets.

Элемент `targets` содержит в себе перечисление элементов `modules`, которые явным образом определяют контекст привязки перехватчиков.
В свою очередь элемент `modules` может быть как пустым, в случае чего объект wrapper'а привязывается к его глобальному контексту, либо содержать вложенные элементы "part", которые определяют некоторый из разделов данного модуля.
В том случае, если элемент `part` имеет в своей структуре вложенные элементы `wrapper`, к данному разделу будет привязан список объектов, обращение к которым идёт в контексте `wrapper`, иначе к нему будет привязан один объект, определённый параметром "wrapper" текущего элемента "part".

## Схема реализации разделения код-представление с использование XML/XSLT ##

Для реализации разделения контента на код реализации и информационное (результативное) представление данных, в системе введёна поддержка механизма XSl(T) преобразований, использование которой подразумевает некоторую спецификацию данных на выходе из модуля.

Каждый модуль на выходе возращает XML-структуру имеющую следующую спецификацию, которая будет использоватся в качестве входных данных в контексте обработки XSL-документа XSL(T) процессором, для получения на выходе XML-совместимого HTML-документа:
```
<?xml version='1.0'?>
<output>
   <transform>
     <item href='{%module_root%}/xsl/some_style.xsl' type='text/xsl'/>
   </transform>
   <infoset>
      <title>
      <![CDATA
        Page Title Text
      ]]>
      </title>
      <css></css>               ; Inline declaration or <item>'s list
      <script></script>         ; Inline declaration or <item>'s list
      <params>
        <key1>value1</key1>
        <!--......-->
        <keyN>valueN</keyN>
      </params>
   </infoset>
   <urlset:url>
       <!-- Exaple URL-parts exporting as XSL-variables -->
       <var number='1' import-as='product_id' type='number'/>
       <var number='2' import-as='product_title' type='string'/>
       <var number='3' import-as='user_id' type='number'/>
   </urlset:url>
   <vars>
     <var name='some_varialbe_name' value='some_variable_value'/>
   </vars>
   <dbset:dataset>
      <set id='1'>
         <tables join='left'>
           <item name='some_db_table1' import-as='d'/>
           <item name='some_db_table2' import-as='d1'/>
         </tables>
         <columns>
           <item name='title' from='d' import-as='product_title'/>
           <item name='uid' from='d1' import-as='user_id'/>
         </columns>
         <where>
              <case type='default'>
                 <term1 object='SUMM(d1.count)*SUMM(d1.cost)'/>
                 <term2 object='SUMM(d2.salary)*SUMM(d2.salary)'/>
                 <action type='equal'/>
              </case>
              <case type='or'>
                 <term1 object='(SUMM(d1.count)*SUMM(d1.cost))/SUMM(d2.salary)*SUMM(d2.salary)'/>
                 <term2 object='1.2'/>
                 <action type='less'/>
              </case> 
         </where>
         <order by='some_db_table1.title' way='ascend'/>     ;Optional tag
         <limit count='20'/>                  ; Optional tag
         <group by='some_db_table1.uid'/>     ; Optional tag
      </set>
   </dbset:dataset>    
   <!-- OR this section can have next view:
    <dbset:dataset>
      <query>INLINE DATABASE QUERY</query>
      <columns>
         <item name='selected-column-name' import-as='NAME IN XSL VARIABLE ENVIRONMENT'/>
      </columns>
    </dbset:dataset>
    This way of database query exporting probably will be more comfortable to developers
    and programmers who can strong skills in SQL-query model.
   -->
```

Информационный XML-документ разделяется на четыре подраздела:
  1. Ссылки на XSL-документы
  1. Информационные данные (infoset)
  1. Правила импорта значений URL
  1. Пользовательские переменные
  1. Правила для проведения запроса к БД

После обработки XML-документа вышеуказанной спецификации анализатором системы, документ преобретёт следующую структуру, которая будет экспортирована непосредственно в качестве входных результатов для XSL(T) процессора:
```
; Example structure
<?xml version='1.0'?>
<input>
   <infoset>
      <title>
      <![CDATA
        Page Title Text
      ]]>
      </title>
      <css></css>               ; Inline declaration or <item>'s list
      <script></script>         ; Inline declaration or <item>'s list
      <params>
        <key1>value1</key1>
        <!--......-->
        <keyN>valueN</keyN>
      </params>
   </infoset>
   <url>
     <item name='some_var' value='some_value'/>
   </url>
   <dbset:dataset>
     <set id='1'>
       <results>{%returned_rows_count%}</result>
       <fields>{%returned_fields_count%}</fields>
       <time>{%elapsed_time%}</time>
       <rows> 
         <item id='1'>
         <product_title>product_title</product_title>
         </item>
       </rows>
      </set>
    </dbset:dataset>
</input>
```