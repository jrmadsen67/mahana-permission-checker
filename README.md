mahana-permission-checker
=========================


###Mahana Permission Checker (ACL for Laravel)###

An ACL library for Laravel. Has a Mahana Hierarchy library dependency (https://github.com/jrmadsen67/mahana-hierarchy-laravel)

IMPORTANT NOTE: still in active development - I'm currently tweaking & rearranging bits for a project I'm developing, so this is working, but package configuration, etc. is still being finalized. "How to Use" coming soon. If you are desperate to use it now, ping me and I'll try to help you get set up.


###Installation###

Available (recommended) via composer:

	"require": {
		 "jrmadsen67/mahana-permission-checker": "dev-master"
	}

In you Laravel app.php file add this to providers:

		'Jrmadsen67\MahanaHierarchyLaravel\MahanaHierarchyLaravelServiceProvider', // you should have this from earlier install
		'Jrmadsen67\MahanaPermissionChecker\MahanaPermissionCheckerServiceProvider'


and this to your facades (optional):

		'MahanaHierarchy' => 'Jrmadsen67\MahanaHierarchyLaravel\Facades\HierarchyFacade',  // you should have this from earlier install
		'PermissionChecker' => 'Jrmadsen67\MahanaPermissionChecker\Facades\PermissionCheckerFacade',

then run the migration:

	php artisan migrate --package="jrmadsen67/mahana-permission-checker"




A data seeder for experimenting and testing is coming soon.

###Configuration###

Table name and fields are completely configurable to your needs. Simply publish the package with the following:

	php artisan config:publish jrmadsen67/mahana-permission-checker

IMPORTANT! If you wish to use the included migration, run the publish config line BEFORE the migration and your new table 
name and fields will be used.
 

###Testing###

This is fully tested, but proper Unit Testing is not yet included until done a little more...er, "properly".

