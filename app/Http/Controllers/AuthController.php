<?php

namespace App\Http\Controllers;

use App\Classes\RemoveBackgroundClass;
use App\Models\User;
use App\Services\RemoveBackgroundService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // TODO: Tratar o FormRequest

        // $credentials = $request->only('email', 'password');

        // if (!auth()->attempt($credentials)) {
        //     return response()->json(['message' => 'Credenciais inválidas'], 401);
        // }

        // return response()->json([
        //     'message' => 'Logado com sucesso!',
        //     'data' => [
        //         'token' => auth()->user()->createToken('auth-token')->plainTextToken,
        //     ]
        // ], 200);
        $removeBg = new RemoveBackgroundService($request->base);
        // $removeBg->removeBgUrl();
        //$removeBg->removeBgFile();
        $removeBg->removeBgBase64();
    }

    public function register(Request $request, User $user): JsonResponse
    {
        // TODO: Tratar o FormRequest
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->remember_token = Str::random(10);
        $user->save();

        if (!$user) {
            return response()->json([
                'messageError' => 'Não foi possível cadastrar usuário'
            ], 400);
        }

        return response()->json([
            'message' => 'Cadastrado com sucesso!',
            'data' => [
                'user' => $user,
            ]
        ], 200);
    }

    public function logout()
    {
        if (auth()->user()->currentAccessToken()->delete()) {
            return response()->json(['message' => 'Deslogado!'], 200);
        }
    }
}
