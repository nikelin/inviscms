# The review #

The policy of safety of system is based on the following cores is put

  1. Safety of user authorization  session
> 2. Guarantee of a level of safety of installed packages and modules from foreign suppliers
> 3. Division of access rights and powers of users of system

The basic functions for management of authorization sessions is delivered by a package **security**, thus processing of sessions at lower level is provided with a package **sessions** (See the User sessions). Methods for definition of powers of the user and creation of policies(politics) of safety, are applied methods of a package **permissions**.

So, the basic component of the general policy of safety of any system - prevent any sort of intervention from the third parties in work of system, or attempt to receive the information, to which they have no access rights.

For this purpose all system is broken into two logic has undressed - the Administrative interface and the User interface.

Access to all without exception (well unless exception is module " Authorization ") is possible only to the user with the rights of the manager. At what, in the User section as there are those sections to which not all users have access, and only the some people, that as it is necessary to consider.
Structures of access and differentiation of the rights

On this, in system concept "AccessProfile" is entered. The example of object `AccessProfile` Further follows:

```
AccessProfile: {
   identifier,
   name
}
```

As a matter of fact speaking a structure represents only the index - a key of access, on которму will be the rights of the user will be determined.

Access rights to that or other module concerning some copy of object SecurityPolitics will be defined with object SecurityPolitics which object has the following specification:

SecurityPolitics: {
> identifier,
> module,
> section,
> ProfileIdentifier,
> AccessMode: (0,1,2)
}

That is, the general policy of safety for some module, consists of set of policies(politics) which define the rights of the user to access to that or other section of some module, in a context of a structure which specifies ProfileIdentifier, with the rights declared as with AccessMode.

Blocking of access are meant as the actual rights пользоваля on access to the specified section of the given module. It can accept following values:

> 0  -  access is forbidden
  1. - "reading-only" mode
> 2  -  "read+write" write

If at the given structure in a context given разделя the module of the right are established in value "read-only ", the user with such structure has no rights to make any changes in structure of data but only only to familiarize with them.

## User authorization process ##

For удостоврения persons of the user, in system the flexible and reliable mechanism of authorization which gives to the user following opportunities of the identification card is entered:

  1. The mechanism of **Fast Procedure of Authorization** (FAP)
  1. The mechanism of **Standard Procedure of Authorization** (SPA)
  1. The mechanism of the **Certificate of Safety** (SS)

So, let's consider a standard case of usual procedure of authorization during which the user specifies the unique code which represents of six integers and as applies in the special image generate a key.
Success of check of the given sheaf will testify that the person really is the authentic user of system and that it can give an opportunity to get access to modules of system to which to it access allows to get its structure of powers.

After the user has passed authorization, on the party of the north the session adhered to the IP-address of the user which will be accessible in current of 120 minutes then it will be again necessary for user to pass procedure of authorization, for acknowledgement of reliability of the person is created.

However the user for those or other reasons could choose a non-standard way of authorization, and choose or procedure of authorization SS or FAP.

The opportunity of authorization of the user is meant procedure FAP under the unique reference valid only for one authorization then it changes in system.

For authorization in system on a method of procedure FAP, the user simply passes under the reference at which there is an especial parameter which defines a current unique key on which fast authorization is possible. After transition under the given reference, current value of a key changes on new, casual image generated which subsequently sends to user mail box.

Technology SS which while is only the specification, and not implemented in the practical plan is more interesting as technological features.

The essence of the given procedure of authorization, consists in authorization passing a browser, and using for sending data and authorization the certain client software.

For use of report **SS**, to the user enough a usual Flash-card, or a disk, with the installed program, and as the user certificate. After installation of the program on the carrier, it is installed as the appendix for autostart, and after passage of procedure of connection of the device to system, the program starts and if check of the enclosed certificate has passed successfully for current IP the user new session which as well as other will be is created lasts 120 minutes, and will allow to work free with system.

The certificate represents the same key which is used in a context of procedure FAP, however in this case the user does not have requirement to pass procedure of authorization on a site, together that simply to start the program, or to insert the Flash-store into USB-port.
At the given stage - exclusively at a pre-alpha stage.

The prioritiest for safety of users is the question on danger of drawing to their system of damage because of use of doubtful packages by them and modules which can contain obviously destructive instructions to a server.

For prevention of similar danger, the report 3RDValidation which serves for check of authenticity of packages, and is entered by their each component.

Each developer can register the package in repositories of projects InvisCore, and receive unique RegCode which will identify their package/module.

The validation of package consists in calculation of checksum (MD5-algorithm) of all compound deliveries of foreign vendor, and their comparison in similar value on the party(side) of a server-source **3RDValidation**?. Check occurs concerning record to RegCode-value and the version равнойм to transferred data on the party of a validation server.