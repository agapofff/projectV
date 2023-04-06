<?php

namespace app\services\admin;

use app\entities\admin\Log;
use app\repositories\LogRepository;

class LogService
{
    private $logRepository;

    public function __construct(
        LogRepository $logRepository
    )
    {
        $this->logRepository = $logRepository;
    }

    public function create(
        $type,
        $request,
        $response
    )
    {
        $log = Log::create(
            $type,
            $request,
            $response,
            0
        );
        $this->logRepository->save($log);
    }

    public function changeStatus($id, $status)
    {
        $log = $this->logRepository->get((int)$id);
        $log->changeStatus(
            $status
        );
        $this->logRepository->save($log);
    }
}
