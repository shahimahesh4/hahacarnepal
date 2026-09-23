<?php

namespace App\Console\Commands;

use App\Domain\Alerts\Actions\EvaluatePriceAlertsAction;
use Illuminate\Console\Command;

class EvaluatePriceAlertsCommand extends Command
{
    protected $signature = 'alerts:evaluate';
    protected $description = 'Evaluate active due price alerts against latest car rental rates';

    public function handle(EvaluatePriceAlertsAction $action): int
    {
        $this->info('Starting price alerts evaluation...');
        $triggered = $action->execute();
        $this->info("Completed price alert evaluation. {$triggered} notification(s) sent.");

        return Command::SUCCESS;
    }
}
