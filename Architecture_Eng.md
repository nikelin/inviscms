### Данная статья на Русском языке: [Read](Architercture.md) ###

# Overview #

This article describes the main approaches to the inner architecture of the system:

  1. The approach to implementing structural engine
> 2. Basic system core unit - "**Package**"
> 3. Organization and management package
> 4. Approaches to extensibility and updates

# Details #

## Engin structural realisation ##

The main challenge posed to the engine, during his razrabotkm was the highest level of flexibility and convenience for developers in porting third-party solutions to the system. In this context, a very high priority was given specifications and standardization protocols interaction packages, as well as ensuring data management package.

To better understand the operation of engine and structural parts worth considering katalogo tree, which comprise the base engine:

```
-- /
  -- Config.xml; Main kernel settings
  -- Install.php; System installation script
  -- Index.php; System startpoint
  -- Sl.php (PROPOUSED: admin.php); Administration UI
  -- Upart.php; Client (foreign visitor) UI
  -- Dx.php; Ajax methods caller
  -- Lib; InvisCMS Engine
  -- Core; System branches
      -- Abstractions; Packages abstractions
        -- Defaultpackage
          -- Def.php
      -- Interfaces; Packages interfaces
        -- Defaultpackage
          -- Def.php
      -- Errors; Packages errors definitions
        -- Defaultpackage
          -- Def.php
      -- Packages; Packages mainclasses
        -- Defaultpackage
          -- Init.php (+); File with baseclass implementation
          -- Config.xml (*); Some common configuration, which uses in package context (OPTIONAL)
          -- Info.xml (+); Information about package
          -- Dependings.xml (+); Dependings information
          -- License.xml (*); File with license bode (OPTIONAL)
      -- Others (PROPOUSED: `libs`); Others librariries (NOT PACKAGES)
        -- Init.php; "Magic" script what provide linking of all packages
        -- Globals.php; Some basic helpful functions
    -- Jscore; System javascript core
      -- Basecore; Base javascript core functions
        -- Jallib; JavascriptActiveLibraries root directory
          -- Defaultlib
            -- Functions.jal; JAL package implementation
      -- Thirdpart; Thirdpart javascript packages
    -- Skins; System templates and styles
     -- Default
       -- Styles
    -- Temp; Directory to save different temprorary informations and files
      -- Uploads; Uploaded by visitors files
      -- Logs; System events history
      -- Files; Files uploaded from administration part
      -- Backups; Backup of some system data (Example: Article changes hronology, clients base)
    -- Modules; Modules packages
      -- Admin; Admin-part modules
        -- Defaultmodule
          -- Actions; Actions for client-side events (what was excepted by POST)
          -- Forms;
            -- Main.frm (+); Module start-point (this script will be automaticle called, when will requested by system)
            -- Config.xml (+); Module common configuration settings
            -- Info.xml (+); Information (authority) about this module
            -- License.xml (*); License information
            -- Dependings.xml (+); Package dependings information
      -- Client
```

As can be seen examining the structure of directories unit "package" is divided into several logical parts, which together represent a holistic object "Package". During the request for connection to the package, initially will be processed file dependings.xml, which is structured as follows:

```
<? xml version ='1 .0 'encodings =' utf-8 '?>
<data>
   <item type='(abstraction|package|errors|interface|lib)' value='{%dependense_identifier%}'/>
   ....
</ data>
```

In the case of a request package (option **type** in the sense of **package**) it will be an attempt to connect dependent package (if it is registered in the system), after which the processing will be transferred back. In case of addictions treatment was not successful, then this fact is added to the story, and the system generates an appropriate exception.

For better organization of packages in the system exists Index (repository) packages, which kept information on all available at this time packages.

Repository is updated at the time of loading a new package or upgrade one already registered. The structure of the facility more inherits from Islands of the "package" and may be presented as follows:

Package: (
> Staus: ( "Insert", "Off")
> Id,
> Name,
> Dependencies: [(Type\_1: identifier\_1 },...,{ Type_N: identifier_ N)],
> Version,
> PublicationDate,
> By,
> LicenseType,
> LicenseAddress
);

In the base supply system is composed of the following basic packages that provide the operating system, and are connected in any case: system, modules, database, errors.

Speaking of packages, one can not recall such issues as annex 3 - their suppliers, against whom are nominated by the following requirements:

  1. Meeting the specifications packages
> 2. The absence of danger to the user
> 3. Support for the current version of the platform
> 4. The authenticity of information supplied

To this end, the following measures:

  1. The possibility of registering their developers packages on the server side developer InvisibleCore? free certification package and identifying them with the registration key, which will be established record on the server side developer system, which will be stored information that will further identify the supplier and its product.
> 2. To provide users the ability to package before installing the system to convey some information about him (including supplied with him the **key-ID**), for confirmation authenticity of the package and its security.

In order to increase the number shipped in the delivery of basic packages, decisions supporter of suppliers in the system are the following possibilities:

  * Management System updates
    * PatchController package
    * Request updates sent to the company's server-vendor packages via HTTP protocol, in response to that, if there is updated, is transmitted XML-compatible document specifying the date of release versions and release a list of changes mandatory installation is on the side of the company supplying the gateway for processing requests for updated (API-interface "system updates)
  * The installation system and request for new packages
  * Extending Package
    * Request new packages sent to the server system developer of a protocol HTTP, as a response to that is transferred to the XML-compatible list of available for downloading packages (transmitted fields correspond to the specifications of the "package")

## Subscription packages ##

At this stage, there is an automatic connection, and the creation of copies of each placed in the register packages (**directory**) package automatically during the launch core script. However, the release will be required to connect only current module packages (not including the list of basic packages), which should significantly reduce processing time and the system load.

Another problem the current version of the system is connected with the processing of data files packages. As the repository of packages (in other words hash of all packages) before the end has not been introduced, at this stage, the system does not mounts packages based on data from the database, and every time produces processing supplied with the package **XML** data, which greatly affects the level load on the server.

To connect the packages used annex **/ lib / core / others / init.php**, which produces processed list of available packages at the moment, and with the successful handling of their mounts in the global environment.

Proposed allow developers to indicate the possibility of creating additional copies of the object package, other than copies of the global environment, which should appear in the configuration file as a parameter **instances\_allow**, which can acquire meaning **yes** or **no**.

Especially package is a package system, which is not podklyuchyaetsya standard pattern, and connects directly to the document **init.php**, with the number of copies of this package could not be more than one. This occurs for the reasons that it is the package and has functions for the implementation of connecting other packages.

Object System delivers public following methods:
```
interface system
(
   / **
   * @ Return bool
   ** /
   public function registerPackage ($ indentifier);
   / **
   * @ Return bool
   ** /
   public function loadLibs ();
  
   / **
   * @ Return bool
   ** /
   public function autoLoad ($ mode = "auto");

   / **
   * @ Return bool
   ** /
   public function loadOneLib ($ identifier);
)
```

## Extensibility in the context of the modular structure of the organization ##

At the higher level of abstraction packages in the tree is an object module, which directly mainly at the site package, and that is using its functional base.

Delivery of the module has the following mandatory components:

  * Default\_module
    * actions
      * **main.inc
    * forms
      *** main.frm
      * **config.xml -
      *** info.xml
      * **license.xml
      *** dependings.xml

When requesting module for connecting the system will be asked file **main.frm**, which will be connected in the context of the module's method modules function '**eval ()** `. In doing so, to the local environment methods **modules:: loadModule ()** includes all current connected copies of the packages at the same time, each module inherits **$this-class** modules, and inherited (clearly) the names of other classes.

Handling events forms to be processed in the context of one of the components of the module, occurs as follows:

  * As part of the form element is supplied with the name: _action**(% event%)**
  * Each name (% event ^) must conform to the file (% event%). Inc, the directory. / Actions, which will is necessary logic for processing forms._

  * **Object Module is following submission:
```
    Module: {
      Status: ( 'included', 'disabled'),
      Id,
      Name,
      Events: [( 'identifier_1': 'name_1'},...,{' identifier_1': 'name_1')]
      Dependencies,
      By,
      Version,
      RealseDate
    };
```
During connecting each module, also automatically draws the navigation menu, which allows the user to perform conversions within the context of each individual module, and as a text link takes title events, but as an identifier section module - identifier events.**

Example: http://host.domen/admin/module1/main (/ args)

In this case, will be connected sect main (**main.frm**) module module1. The same might indicate some parameters optional module, but the current version of the system for their domestic processing solely responsible implementation of the module, which has access to global variables object recovered from the base **URI**, which may take the necessary data.

Because the system uses a system originally **MUA** (man-understandable addresses), based on the Apache-supplied technology **ModRewrite**?, have a question: "**In which case seek module as well as transfer the management of certain modules of the system?".**

The problem is most clearly expressed in the case of a request to the administrative section (we need because it is changing contexts, rather than request module admin), or from accessing pages on the short address, or their ID (an opportunity which comes just in the baseline version of the system) .

For this reason, the system there are exceptional situations processing addresses.

The special situation of processing addresses - a situation in which ID is a keyword in the system, or a reserved address.

For exceptional situations processing system checks the ID of the first level of nesting, in relation to the root URI ('/'), and if that is reserved word, produces appropriate action, or plug-ins.

In the case of a disputed situation between the module and a reserved address (overlapping the first last, or vice versa), the priority is given module. That is, first involves checking the possibility of a connection module with an appropriate identifier, after which control is passed or module, depending on the success of verification, or the next conditional constructions, to explore possible reserved addresses. In this case all the checks will fail, the module is connected with id default.

As with the package, modules organized modules index (**repository**), which inherits all-wah object "**module**", while supplement `**AccessProfile**'.

```
Module: (
  ...
  AccessProfiles: [ 'Indentifier_1',...,'Indetifier_N']
)
```

Profile indentifier corresponds to access a copy of "**AccessProfile**" (see **Security politics**?), and during the request for connection of the module in the first place entering the user checked in the group, the profile of access, which designated matches ID from the array **AccessProfiles** this module.