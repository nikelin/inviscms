# Overview #

This article describes the main ideas and approaches to the implementation process of installing the system on a user's computer.

# Details #

Since the main purpose and idea system is the incarnation expand and flexible plaftormy to develop web-projects and, in general, its functional structure and content are not determined at the time of its installation, and proper and not known to the list of modules, and the process itself "first-time" configuration should fall on the shoulders of the packages included in this package.

The first step of installing the system user enters basic information, namely:

  1. A password and user ID to the profile root.
> 2. System path (URL path to the system, the path to a system in the file environment).

As well as selects the list of modules, which he wants to make an active, and allow operation.

Then, on the second step of the installation, the system checks the list of selected packages, and if your "**need-install**" in their configuration file (see "**Architecture engine**?") Set to "**yes**", then the system activates the **install.php** file from the directory "**(% package%) / .install / proceed.php**".

Setting packages happening in fomit mode, given the dependence between them, that is a process configuration package, which depends on some other package, will not happen before setting a package on which they depend.

Sign of a successful conclusion settings package will serve as the creation of variable (on the part of a package installation file) session with the name "_md5 ((% pack%)**+"success")**". In any case, the user can manually (clicking on "**Ignore**") adjusts to miss this package, if its value (importance), specified in the configuration file is not in the sense of **critical**. If its value **critical**, then installation is completed in emergency mode, otherwise the system itself adds session variable determining the status install this package as "**successful**"._

The third step, after a process of configuring the packages should be the setup process modules, which is identical tuning packages.

Upon completion, the system gives the user record of successfully / not successfully installed modules / packages, and, depending on the outcome of the installation as a whole, reports of successful or not successful installation of the system.

At the system level processing takes place the following events:

  1. The transition from one phase to another installation
  1. The transition from one module settings / package to another
  1. The exodus of some settings module / package
  1. Errors associated with connection packages / modules and processing their configuration files
  1. Result installation process

If you said about the process of collecting bugs / communications regarding the context of customizable modules / packages, it should be noted that early in the process of installing the system, creates a global environment for recording communications system for all modules, from which information will be added later and the basic file stories, and it is in error should not write / messages all modules in the context of first-time settings.

After the installation process will be completed, all the modules installed in the directory **/.install** file will be added **/.lock**, which would indicate that the module has passed primary phase of installation.