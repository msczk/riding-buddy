<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:ask-for-rating')->daily();
Schedule::command('auth:clear-resets')->everyFifteenMinutes();