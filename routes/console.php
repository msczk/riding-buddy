<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:ask-for-rating')->daily();