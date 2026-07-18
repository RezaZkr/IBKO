<?php

namespace Modules\General\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GeneralServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'General';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'general';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
    ];

    /**
     * Define module schedules.
     *
     * @param $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }

    public function boot(): void
    {
        parent::boot();


        $response = app(ResponseFactory::class);
        if (!$response->hasMacro('success')) {
            $response->macro('success', function (string $message = null, $data = null, int $status = ResponseAlias::HTTP_OK) use ($response) {
                $responseData = [
                    'success' => true,
                    'status'  => $status,
                    'message' => $message ?? trans('general::message.success'),
                    'data'    => $data ?? [],
                ];
                return $response->json($responseData, $status);
            });
        }
        if (!$response->hasMacro('error')) {
            $response->macro('error', function (string $message = null, array $errors = [], int $status = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR) use ($response) {
                $responseData = [
                    'success' => false,
                    'status'  => $status,
                    'message' => $message ?? trans('general::message.error'),
                    'errors'  => [],
                ];
                if (count($errors)) {
                    $responseData['errors'] = $errors;
                }
                return $response->json($responseData, $status);
            });
        }

    }
}
