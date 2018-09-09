<?php

return [
	'action' => [
		'add' => ':user has just created an action [:action_name] for your group',
		'cancel' => ':user has just canceled an action [:action_name] or assigned this action to another group',
	],
	'task' => [
		'add' => ':task_owner has just assigned a task [:name] to you',
		'status_change' => '[Task: :name] Status has been changed from [:old] to [:new]',
		'cancel' => ':task_owner has just canceled an action [:name] or assigned this action to another people',
	]
];
