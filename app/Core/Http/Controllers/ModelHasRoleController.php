<?php


namespace App\Core\Http\Controllers;


use App\Core\Domain\RoleEntity;
use App\Core\Domain\UserEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModelHasRoleController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer|exists:roles,id',
            'model_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $usuario = UserEntity::find($request->model_id);
        $perfil = RoleEntity::find($request->role_id);

        $objUserSucess = $usuario->assignRole($perfil->name);

        $response = ['data' => $objUserSucess instanceof UserEntity];

        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer|exists:roles,id',
            'model_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $usuario = UserEntity::find($request->model_id);
        $perfil = RoleEntity::find($request->role_id);

        $objUserSucess = $usuario->removeRole($perfil->name);

        $response = ['data' => $objUserSucess instanceof UserEntity];

        return response($response, 200);
    }
}