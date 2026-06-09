<?php

declare(strict_types=1);

use App\Livewire\Booking\BookingCalendar;
use App\Livewire\Booking\BookingForm;
use App\Livewire\Booking\ServiceManager;
use App\Livewire\Crm\CustomerDetail;
use App\Livewire\Crm\CustomerList;
use App\Livewire\Crm\FollowUpList;
use App\Livewire\Crm\PipelineBoard;
use App\Livewire\Dashboard;
use App\Livewire\Projects\ProjectDetail;
use App\Livewire\Projects\ProjectList;
use App\Livewire\Projects\TaskBoard;
use App\Livewire\Settings\ProfileSettings;
use App\Livewire\Settings\TeamSettings;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

Route::middleware(['web', InitializeTenancyByPath::class])
    ->prefix('{tenant}')
    ->group(function () {

        Route::middleware(['auth'])->group(function () {
            Route::get('/dashboard', Dashboard::class)->name('tenant.dashboard');

            // Booking module
            Route::prefix('booking')->name('tenant.booking.')->group(function () {
                Route::get('/', BookingCalendar::class)->name('calendar');
                Route::get('/new', BookingForm::class)->name('new');
                Route::get('/services', ServiceManager::class)->name('services');
            });

            // CRM module
            Route::prefix('crm')->name('tenant.crm.')->middleware('module:crm')->group(function () {
                Route::get('/customers', CustomerList::class)->name('customers');
                Route::get('/customers/{customer}', CustomerDetail::class)->name('customer');
                Route::get('/pipeline', PipelineBoard::class)->name('pipeline');
                Route::get('/follow-ups', FollowUpList::class)->name('follow-ups');
            });

            // Project Management module
            Route::prefix('projects')->name('tenant.projects.')->middleware('module:pm')->group(function () {
                Route::get('/', ProjectList::class)->name('index');
                Route::get('/{project}', ProjectDetail::class)->name('show');
                Route::get('/{project}/tasks', TaskBoard::class)->name('tasks');
            });

            // Settings
            Route::prefix('settings')->name('tenant.settings.')->group(function () {
                Route::get('/', ProfileSettings::class)->name('profile');
                Route::get('/team', TeamSettings::class)->name('team');
                Route::get('/services', ServiceManager::class)->name('services');
            });
        });
    });
