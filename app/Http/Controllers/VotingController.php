<?php

namespace App\Http\Controllers;

use App\Events\VotedEvent;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function store(Request $request)
    {
        VotedEvent::dispatch($request->only('confrontationId', 'isHome'));
    }
}
