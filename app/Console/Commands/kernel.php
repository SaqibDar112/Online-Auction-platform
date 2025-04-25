protected function schedule(Schedule $schedule)
{
    $schedule->command('auctions:close')->everyMinute();
}