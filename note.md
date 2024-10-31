# Note

task scheduler

    * * * * * cd /your_project_root_folder && php -d register_argc_argv=1 artisan schedule:run >> /dev/null 2>&1

swaggervel

	if error
	Temporary solution
	Go to vendor/jlapp/swaggervel/src/Jlapp/Swaggervel/routes.php

	Remove this two line

	Blade::setEscapedContentTags('{{{', '}}}');
	Blade::setContentTags('{{', '}}');