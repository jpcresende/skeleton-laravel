<?php


namespace App\Core\Http\Controllers;

use App\Core\Domain\UserEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AutenticacaoController
 * @package App\Core\Http\Controllers
 */
class AutenticacaoController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $user = UserEntity::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = "Senha incorreta";
                return response($response, 422);
            }
        } else {
            $response = 'Usuário não encontrado';
            return response($response, 404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = 'Logout realizado com sucesso!';
        return response($response, 200);
    }
}
