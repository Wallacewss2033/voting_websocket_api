<?php

namespace App\Http\Controllers;

use App\Events\VotedEvent;
use App\Models\User;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function store(Request $request)
    {
        VotedEvent::dispatch($request->only('confrontationId', 'isHome'));
        return response()->json(['success' => true, 'message' => 'Voto computado!'], 200);
    }
}
