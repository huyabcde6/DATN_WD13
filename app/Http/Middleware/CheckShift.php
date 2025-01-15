<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class CheckShift
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Bạn cần đăng nhập để tiếp tục.']);
        }

        $currentTime = now()->format('H:i:s'); // Lấy giờ hiện tại
        $currentShift = null;

        foreach ($user->shifts as $shift) {
            if (
                $shift->is_overnight &&
                ($currentTime >= $shift->start_time || $currentTime <= $shift->end_time)
            ) {
                $currentShift = $shift;
                break;
            } elseif ($currentTime >= $shift->start_time && $currentTime <= $shift->end_time) {
                $currentShift = $shift;
                break;
            }
        }

        if (!$currentShift) {
            return redirect()->route('home.index')->withErrors(['error' => 'Bạn không có quyền truy cập ngoài giờ làm việc.']);
        }

        return $next($request);
    }
    
}
