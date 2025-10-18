<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FollowService;

class FollowController extends Controller
{
    protected $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    public function toggle(User $user)
    {
        try {
            $me = auth()->user();

            $this->followService->toggleFollow($me, $user);
    
            return back();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
       
    }
}