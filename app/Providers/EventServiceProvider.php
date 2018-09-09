<?php

namespace App\Providers;

use App\Events\Backend\AddTask;
use App\Events\Backend\UpdateAction;
use App\Events\Backend\UpdateTask;
use App\Events\Backend\AddAction;
use App\Listeners\Backend\AddTaskNotification;
use App\Listeners\Backend\UpdateActionNotification;
use App\Listeners\Backend\UpdateTaskNotification;
use App\Listeners\Backend\AddActionNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UpdateTask::class => [
            UpdateTaskNotification::class,
        ],
	    AddTask::class => [
	    	AddTaskNotification::class
	    ],
	    AddAction::class => [
		    AddActionNotification::class
	    ],
	    UpdateAction::class => [
	    	UpdateActionNotification::class
	    ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
