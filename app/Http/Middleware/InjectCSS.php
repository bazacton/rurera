<?php
namespace App\Http\Middleware;

use Closure;

class InjectCSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array|string  $cssFiles  Array of CSS files to include
     * @return mixed
     */
    public function handle($request, Closure $next, ...$cssFiles)
    {
        // Share the CSS files with all views
        view()->share('cssFiles', $cssFiles);

        return $next($request);
    }
}
