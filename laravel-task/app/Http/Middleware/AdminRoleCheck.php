<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
 

class AdminRoleCheck
{
    
    /**
     * Handle an incoming request.
     * validate the auth token and content type
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    
    { 
        if ($request->user()->roles == 2) {
            return redirect("/userIndex");
        }else{
            return redirect("/getApproveUser");
        }
        
        
    }
    
     
}