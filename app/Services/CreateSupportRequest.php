<?php

namespace App\Services;

use App\Mail\SupportRequestMail;
use App\Models\SupportRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class CreateSupportRequest
{

    /**
     * @var array
     */
    protected $types = [
        'feature' => "support+features@foo.com",
        'help' => "support+help@foo.com",
        'bug' => "support+bug@foo.com",
    ];

    public function handle(array $payload): SupportRequest
    {
        $request = SupportRequest::create($payload);

        if ($type = Arr::get($payload, 'type')) {
            $this->sendEmail($type, $request);
        }

        return $request;
    }

    private function sendEmail(string $type, SupportRequest $request): void
    {
        Mail::to($this->types[$type])
            ->send(
                new SupportRequestMail($request)
            );
    }
}
