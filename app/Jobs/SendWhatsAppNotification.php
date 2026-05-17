<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $target;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($target, $message)
    {
        $this->target = $target;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FonnteService $fonnteService)
    {
        if (empty($this->target)) {
            Log::warning('WhatsApp target is empty, skipping notification.');
            return;
        }

        $fonnteService->sendMessage($this->target, $this->message);
    }
}
