# Обзор #

Для представления внутренней информации системы конечным пользователям в системе используется базовая структурная единица - модуль, которая служит в качестве UI-представления.

# Детали #

Модули не портируют (**не желательно**) собственного функционала, однако использует все функциональные возможности, поставляемые доступными в системе пакетам (см. **Architecture**).

Для размещения поставок модулей в системе используется диторектория `**./lib/modules**', в которой размещаются все модули системы в отдельных директориях, которые имеет следующую структуру:

```
--default_module
  -- actions
    -- main.inc
  -- forms
    -- main.frm
  -- ui
    -- style
    -- js
  -- rules.php
  -- config.xml
  -- info.xml
  -- dependings.xml
  -- license.xml
  -- hash.xml
```

В директория `*forms*` и `*actions*` располагается основаной функционал для визуализации и проводки информации.
Так, обязательным элементом директории `*forms*` является файл **main.frm**, который будет запрошен в момент загрузки модуля, без указания определённого модуля.
Для обработки события отправки формы, в одной из структурных частей модуля (к примеру "**main.frm**"), используется следующая схема:

  1. Отрисовка пользовательской формы с методом отправки **POST**, включая элемент формы с именем `action_(имя структурной части (к примеру *main*)`.
  1. Заполнение пользователем формы.
  1. Отправка формы на сервер по-методу **`Submit`**, формы.
  1. Подключение файла с серверной логикой, который имеет имя `(имя структурной части (к примеру *main*).inc`

Говоря о структурировании модулей, так же следует оговорить спецификацию информационный файлов и файлов настроек формата **XML**.

Всего в поставку модуля включаются **4** обязательных **XML**-совместимых файлов, которые представляют собой файлы с информаией о разработчике, файлы настроек модуля, а так же зависимости данного модуля (в контексте пакетов).

Далее рассматривается спецификация их внутренней структуры:

**Файл config.xml**:

```

<?xml version='1.0'?>

<config>

    <parts>

        <item>

             <name>Default Part #1</name>

             <system>defpart</system>

             <description>Some description less than 50 symbols</description>

             <status value='off'/>

        </item>

     </parts>

     <system>

         <name>Default Module</name>

         <part>admin</part>

         <status value='on'/>

     </system>

</config>

```

**DTD-спецификация XML-документа**:

```

<?xml version='1.0'?>

<!ELEMENT config (parts+,system+)/>

<!ELEMENT config.parts item+/>

<!ELEMENT config.parts.item (name+,system+,description?,status+)/>

<!ELEMENT config.parts.item.name #PCDATA/>

<!ELEMENT config.parts.item.system #PCDATA/>

<!ELEMENT config.parts.item.description #PCDATA/>

<!ELEMENT config.parts.item.status EMPTY/>

<!ATTLIST config.parts.item.status

                    value ('on','off') 'on'/>

<!ELEMENT config.system (name+,part+,status+)/>

<!ELEMENT config.system.name #PCDATA/>

<!ELEMENT config.system.part #PCDATA/>

<!ELEMENT config.system.status EMPTY/>

<!ATTLIST config.system.status

                    value ('on','off') 'on'/>

```


**Файл info.xml**:

Описание: информационный файл, содержащий:
данные о поставщиках (разработчиках) данного модуля;
  * адреса службы поддержки (адресами разработчиков);
  * версию текущего модуля;
  * версию системы, на функционале которой базируется данный модуль;
  * дату официального релиза текущей версии модуля;
  * языки, поддержку которых данный модуль реализует;
  * краткое описание данного модуля.

```

<?xml version='1.0'?>

<info>

    <authors>

        <people name='Leonardo V. Sadir' company='1' role='Core Development'/>

    </authors>

    <companies>

        <item name='InnoWeb Ltd.' role='UI Design' address='http://innoweb.org.ua'/>

    </companies>

    <support>

        <item name='tech' value='support-32@innoweb.org'/>

        <item name='advertising' value='support-9@innoweb.org'/>

    </support>   

    <version>1.0.5-beta</version>

    <published>24-10-2008</published>

    <i18n>

        <lang id='ru-RU'/>

        <lang id='en-US'/>

    </i18n>

    <description>

        Some description of this module

    </description>

    <system-min-version value='1.0-stable'/>

</info>

```

**DTD-спецификация XML-документа:**

```

<?xml version='1.0'?>


<!ENTITY     % author     #INCLUDE/>


<![%people;[

    <!ELEMENT     people     EMPTY/>

    <!ATTLIST  people

                name     CDATA     #REQUIRED

                role     CDATA     #REQUIRED

                company     %company.item;     #IMPLEMENTED/>

]]>

<![%company;[

    <!ELEMENT     item     EMPTY/>

    <!ATTLIST     item

                name     CDATA     #REQUIRED

                role     CDATA     #REQUIRED

                address     CDATA     #REQUIRED/>  

]]>


<![%support;[

    <!ELEMENT     item     EMPTY/>

    <!ATTLIST    item

                name     CDATA     #REQUIRED

                value     CDATA     #REQUIRED/>

]]>


<!ELEMENT     info     ((authors|%author;?)+,(companies|%company;?)*,support*,version+,published+,i18n+,description+,system-min-version+)/>

<!ELEMENT     info.authors     %author;+/>

<!ELEMENT     info.companies     %company;+/>

<!ELEMENT     info.support     %support;+/>

<!ELEMENT     info.version     #PCDATA/>

<!ELEMENT     info.published     #PCDATA/>

<!ELEMENT     info.i18n lang+/>

<!ATTLIST     info.i18n.lang

                id     CDATA     #REQUIRED/>

<!ELEMENT     info.description     #PCDATA/>

<!ELEMENT     info.system-min-version     EMPTY/>

<!ATTLIST     info.system-min-version

                    value    CDATA     #REQUIRED/>

```


**Файл dependings.xml**:

```

<?xml version='1.0'?>

<dependings>

    <item part='libs' value='mime-message'/>

    <item part='package' value='mail'/>

    <item part='abstraction' value='payment'/>

    <!--etc.-->

</dependings>

```

**DTD-спецификация XML-документа:**:

```

<?xml version='1.0'?>

<!ELEMENT dependings item+/>

<!ELEMENT dependings.item EMPTY/>

<!ATTLIST dependings.item

                  part ("libs","package","interface","abstraction","errors") #REQUIRED

                  value CDATA #REQUIRED/>

```



**Файл license.xml**:

Описание: файл для описания лицензии, под которым распространяется поставка модуля.

```

<?xml version='1.0'?>

<info>

    <type>opensource</type>

    <name>GNU/GPL v.3</name>

    <url>http://gpl.gnu.org</url>

    <content>

        <item xml:lang='lang-of-content'>

            <!--text-of-license-->

        </item>   

    </content>

</info>

```

**DTD-спецификация документа**:

```

<?xml version='1.0'?>

<!ELEMENT info (type+, name+, (url | content | (content , url))+, content*)/>

<!ELEMENT info.content item*/>

<!ATTLIST info.content.item

                  xml:lang CDATA #REQUIRED "en-EN"/>

```



**Файл hash.xml**:

Описание: Данный файл содержит в себе информацию для проверки аутентичности содержимого поставки модуля, и передаётся на сервер во время валидации содержимого пакета.

```

<?xml version='1.0'?>

<data>

    <item path='forms/main.frm' type='md5' value='{%checksum%}'/>

    <item path='forms/main.inc' type='md5' value='{%checksum%}'/>

    <!--etc.-->

</data>

```

**DTD-спецификация XML-документа**:

```

<?xml version='1.0'?>

<!ELEMENT data (item+ | EMPTY)/>

<!ELEMENT item EMPTY/>

<!ATTLIST item

                    path CDATA  #REQUIRED

                    type (md5,sha1)  #REQUIRED "md5"

                    value CDATA #REQUIRED />

```



