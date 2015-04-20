# Overview #

Many atomic units in the system architecture (packages, modules, libraries, etc.) developed based on other atomic units, without whom lost their relevance and their functioning becomes impossible. In order to avoid possible errors and incorrect operation situations, was introduced unified standard specifications dependencies between modules and packages in system core context.

# Details #

For obvious indications of a package of addictions, in its composition must be keys file-specification **dependings.xml**, with **XML-compatible** format and structured as follows:

```
<? xml version ='1 .0 '?>
<dependings>
   <item type='packages' name='somepackage' rang='critical'/>
   <item type='libs' name='exception'/>
   ......
</ dependings>
```

As an object type dependence indicates the partition where the object increases. Object Type may take the following meanings:

  * Packages
  * Libs
  * Intefaces
  * Abstractions
  * Errors

```
The existence of a parameter rank is optional, and discusses the need for its existence. This 
option is to be listed on the criticality of dependence, and in the absence of a dependent object 
will issue only a warning.
```