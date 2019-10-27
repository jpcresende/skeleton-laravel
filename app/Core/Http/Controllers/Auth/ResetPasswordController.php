<?php

namespace App\Core\Http\Controllers\Auth;

use App\Core\Domain\PasswordResetsEntity;
use App\Core\Domain\UserEntity;
use App\Core\Exceptions\BusinessException;
use App\Core\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        $arrParams = $this->credentials($request);
        $passResetColle = PasswordResetsEntity::where(['email' => $arrParams['email'], 'token' => $arrParams['token']]);
        if ($passResetColle->count() === 0) {
            throw new BusinessException(BusinessException::INVALID_ID, 'Token', 404);
        }
        $objUsuario = UserEntity::where('email', $arrParams['email'])->first();
        $objUsuario->password = bcrypt($arrParams['password']);
        $objUsuario->save();
        return response(['data' => $objUsuario instanceof UserEntity]);
    }
}
