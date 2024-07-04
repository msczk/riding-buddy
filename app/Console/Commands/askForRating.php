<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Trip;
use App\Notifications\AskForRating as NotificationsAskForRating;
use Illuminate\Console\Command;

class askForRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ask-for-rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoi les demandes de notation des balades passées';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $past_trips = Trip::whereDate('start_at', '=', Carbon::today()->subDays(1))->get();

        if(!empty($past_trips))
        {
            foreach($past_trips as $past_trip)
            {
                if(!empty($past_trip->users))
                {
                    foreach($past_trip->users as $user)
                    {
                        if($past_trip->user->id != $user->id)
                        {
                            $user->notify(new NotificationsAskForRating($past_trip));
                        }
                    }
                }
            }
        }
    }
}
