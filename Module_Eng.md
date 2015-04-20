### Данная статья на Русском языке: [Перейти](Module.md) ###

# Overview #

For representation of the internal information of system to end users in system base structural unit - the module which serves as **UI**-representation is used.

# Details #

Modules not provide any own functions, however uses all the functionalities delivered accessible in system to packages (see [Architecture](Architecture.md)).

For accommodation of deliveries of modules in system it is used диторектория `*./lib/modules*`, in which modules of system in separate directories which has following structure are placed all:
```
- default_module
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

In the directory **forms** and **actions** settles down основаной функционал for visualization and posting of the information. So, an obligatory element of a directory **forms** is the file main.frm which will be requested during the moment of loading of the module, without the instruction(indication) of the certain module. For processing event of sending of the form, in one of structural parts of the module (for example **"main.frm"**), the following scheme is used:
  1. Rendering the user form with a method of sending POST, including an element of the form with a name '_action**(a name of a structural part (for example**main**)**'.
  1. Filling with the user of the form.
  1. Sending of the form on a server to method Submit, forms.
  1. Connection of a file with server logic which has a name '**(a name of a structural part (for example**main**).inc**'_

Speaking about structurization of modules as it is necessary to stipulate the specification information files and files of adjustments of format XML.

In total delivery of the module joins 4 obligatory XML-compatible files which represent files with information about the developer, files of adjustments of the module, and as dependences of the given module in a context of packages.

Further the specification of their internal structure is considered(examined):

**File config.xml**:
```
<? xml version = ' 1.0 '?>
<config>
    <parts>
        <item>
             <name> Default Part *1 </name>
             <system> defpart </system>
             <description> Some description less than 50 symbols </description>
             <status value ='off '/>
        </item>
     </parts>
     <system>
         <name> Default Module </name>
         <part> admin </part>
         <status value ='on '/>
     </system>
</config>
```
**The DTD-specification of the XML-document**:
```
<? xml version = ' 1.0 '?>
<!ELEMENT config (parts +, system +)/>
<!ELEMENT config.parts item +/>
<!ELEMENT config.parts.item (name +, system +, description?, status +)/>
<!ELEMENT config.parts.item.name *PCDATA/>
<!ELEMENT config.parts.item.system *PCDATA/>
<!ELEMENT config.parts.item.description *PCDATA/>
<!ELEMENT config.parts.item.status EMPTY/>
<!ATTLIST config.parts.item.status
                    value (' on ', ' off ') ' on '/>
<!ELEMENT config.system (name +, part +, status +)/>
<!ELEMENT config.system.name *PCDATA/>
<!ELEMENT config.system.part *PCDATA/>
<!ELEMENT config.system.status EMPTY/>
<!ATTLIST config.system.status
                    value (' on ', ' off ') ' on '/>
```

**File info.xml**:
`The description`:
The information file containing:
  1. Data about suppliers (developers) of the given module;
  1. Addresses of a support service (addresses of developers);
  1. The version of the current module;
  1. The version of system, on функционале which the given module is based;
  1. Date of official release of the current version of the module;
  1. The given module realizes languages, which support;
  1. The brief description of the given module.
```
<? xml version = ' 1.0 '?>
<info>
    <authors>
        <people name ='Leonardo V. Sadir ' company = ' 1 ' role ='Core Development '/>
    </authors>
    <companies>
        <item name ='InnoWeb Ltd. ' role ='UI Design ' address ='http: // innoweb.org.ua '/>
    </companies>
    <support>
        <item name ='tech ' value ='support-32@innoweb.org '/>
        <item name ='advertising ' value ='support-9@innoweb.org '/>
    </support>   
    <version> 1.0.5-beta </version>
    <published> 24-10-2008 </published>
    <i18n>
        <lang id ='ru-RU '/>
        <lang id ='en-US'/>
    </i18n>
    <description>
        Some description of this module
    </description>
    <system-min-version value = ' 1.0-stable '/>
</info>
```

**The DTD-specification of the XML-document**:
```
<?xml version = ' 1.0 '?>
<!ENTITY     % author     *INCLUDE/>
<![%people; [
    <! ELEMENT     people     EMPTY/>
    <! ATTLIST  people
                name     CDATA     *REQUIRED
                role     CDATA     *REQUIRED
                company     %company.item;     *IMPLEMENTED/>
]]/>
<![%company; [
    <! ELEMENT     item     EMPTY/>
    <! ATTLIST     item
                name     CDATA     *REQUIRED
                role     CDATA     *REQUIRED
                address     CDATA     *REQUIRED/>  
]]/>
<![%support; [
    <! ELEMENT     item     EMPTY/>
    <! ATTLIST    item
                name     CDATA     *REQUIRED
                value     CDATA     *REQUIRED/>
]]/>
<!ELEMENT     info     ((authors | % author;?) +, (companies | % company;?) *, support *, version +, published +, i18n +, description +, system-min-version +)/>
<!ELEMENT     info.authors     %author; +/>
<!ELEMENT     info.companies     %company; +/>
<!ELEMENT     info.support     %support; +/>
<!ELEMENT     info.version     *PCDATA/>
<!ELEMENT     info.published     *PCDATA/>
<!ELEMENT     info.i18n lang +/>
<!ATTLIST     info.i18n.lang
                id     CDATA     *REQUIRED/>
<!ELEMENT     info.description     *PCDATA/>
<!ELEMENT     info.system-min-version     EMPTY/>

<!ATTLIST     info.system-min-version

                    value    CDATA     *REQUIRED/>
```

**File dependings.xml**:
```
<? xml version = ' 1.0 '?>
<dependings>
    <item part ='libs' value ='mime-message '/>
    <item part ='package ' value ='mail '/>
    <item part ='abstraction ' value ='payment '/>
    <! - etc.->
</dependings>
```

**The DTD-specification of the XML-document**:
```
<?xml version = ' 1.0 '?>
<!ELEMENT dependings item +/>
<!ELEMENT dependings.item EMPTY/>
<!ATTLIST dependings.item
                  part ("libs", "package", "interface", "abstraction", "errors") *REQUIRED
                  value CDATA *REQUIRED/>
```

**File license.xml:**
The description: a file for the description of the license under which delivery of the module extends.
```
<? xml version = ' 1.0 '?>
<info>
    <type> opensource </type>
    <name> GNU/GPL v.3 </name>
    <url> http: // gpl.gnu.org </url>
    <content>
        <item xml:lang ='lang-of-content '>
            <! - text-of-license->
        </item>   
    </content>
</info>
```
**The DTD-specification of the document**:
```
<?xml version=' 1.0 '?>
<!ELEMENT info (type +, name +, (url | content | (content , url)) +, content *)/>
<!ELEMENT info.content item*/>
<!ATTLIST info.content.item
                  xml:lang CDATA *REQUIRED "en-EN"/>
```
**File hash.xml**:
`The description`: the Given file comprises the information for check of authenticity of contents of delivery of the module, and is transferred(transmitted) to a server during валидации a contained package.
{{
<? xml version = ' 1.0 '?>


&lt;data&gt;


> 

&lt;item path ='forms/main.frm ' type ='md5 ' value = ' {% checksum %} '/&gt;


> 

&lt;item path ='forms/main.inc ' type ='md5 ' value = ' {% checksum %} '/&gt;


> <! - etc.->


&lt;/data&gt;


<?xml version = '1.0'?>
<!ELEMENT data (item + | EMPTY)/>
<!ELEMENT item EMPTY/>
<!ATTLIST item
> > path CDATA  #REQUIRED
> > type (md5, sha1) "md5"
> > value CDATA #REQUIRED/><?xml version=' 1.0 '?>
<!ELEMENT info (type +, name +, (url | content | (content , url)) +, content *)/>
<!ELEMENT info.content item*/>
<!ATTLIST info.content.item
                  xml:lang CDATA *REQUIRED "en-EN"/>
}}}
*The DTD-specification of the XML-document*:
{{{ 
}}}```