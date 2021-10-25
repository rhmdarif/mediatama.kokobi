<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckPassCodeGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->route()->parameter('id'));
        if(!auth()->check()) {
            if($request->has('passcode')) {
                $checkPasscode = DB::table('groups')->where('id', $request->route()->parameter('id'))->where('passcode', $request->passcode)->count();
                if($checkPasscode) {
                    return $next($request);
                } else {
                    return redirect()->route('group')->with("error", "Passcode salah");
                }
            } else {
                return redirect()->route('group')->with("error", "Passcode harus diisi");
            }
        }

        return $next($request);
    }
}
