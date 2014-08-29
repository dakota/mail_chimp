<?php

CroogoRouter::connect('/mail-list/*', array(
	'plugin' => 'mail_chimp', 'controller' => 'mail_lists', 'action' => 'view'
), ['pass' => ['alias']]);
