<?php

namespace App\Console\Commands;

use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateFines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-fines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and add fines for overdue borrowings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fineRatePerDay = 10; // Rs 10 per day

        // Find borrowings where due date is in the past and they haven't been returned
        $overdueBorrowings = Borrowing::where('status', '!=', 'returned')
            ->where('due_date', '<', Carbon::today())
            ->get();

        $count = 0;

        foreach ($overdueBorrowings as $borrowing) {
            $daysOverdue = Carbon::parse($borrowing->due_date)->diffInDays(Carbon::today());

            if ($daysOverdue > 0) {
                $amount = $daysOverdue * $fineRatePerDay;

                // Update borrowing status if not already overdue
                if ($borrowing->status !== 'overdue') {
                    $borrowing->update(['status' => 'overdue']);
                }

                // Update or create fine
                // Only create/update if the fine is unpaid. If it's already paid, we probably shouldn't increase it?
                // Actually, if it's not returned, the fine keeps increasing. But if it's already marked paid?
                // Let's assume if it's not returned, it can't be fully paid. So we just update.
                $fine = Fine::firstOrNew(['borrowing_id' => $borrowing->id]);

                if ($fine->status !== 'paid') {
                    $fine->user_id = $borrowing->user_id;
                    $fine->amount = $amount;
                    $fine->save();
                    $count++;
                }
            }
        }

        $this->info("Calculated fines for {$count} overdue borrowings.");
    }
}
