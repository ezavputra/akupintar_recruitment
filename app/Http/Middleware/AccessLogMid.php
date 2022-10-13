<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use DateTime;
use Request;
use App\Repositories\AccessLogRepository;
use App\Models\AccessLog;
use App\Models\User;
use App\Models\Role;

class AccessLogMid
{
    public function __construct(AccessLogRepository $AccessLogRepository)
    {
        $this->AccessLogRepository = $AccessLogRepository;
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $role = Role::where('role_name', auth()->user()->role)->first();
        // buat log
        $log['IP'] = request()->ip();
        $log['path'] = Request::fullUrl();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->user()->id;
        $log['role_id'] = $role->id;
        $this->AccessLogRepository->create($log);

        return $response;
    }
}
