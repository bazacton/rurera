<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivitiesLog;

class UserActivityLog
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$clientIpAddress = $request->getClientIp();
		$user = auth()->user();
		$url = $request->url();
		if( isset( $user->id )){
			UserActivitiesLog::create([
				'user_id' => $user->id,
				'log_type' => 'page_visit',
				'ip_address' => $clientIpAddress,
				'visit_location' => $url,
				'created_at' => time(),
			]);
		}
		return $next($request);
    }
}
