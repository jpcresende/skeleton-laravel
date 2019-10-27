<?php

namespace App\Core\Http\Controllers;

use App\Core\Domain\RoleEntity;
use App\Core\Exceptions\BusinessException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        return response(['data' => DB::table('roles as r')
            ->select(
                'r.id',
                'r.name'
            )->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Core\Domain\RoleEntity  $roleEntity
     * @return \Illuminate\Http\Response
     */
    public function show(RoleEntity $roleEntity)
    {
        if (!$roleEntity) {
            throw new BusinessException(BusinessException::INVALID_ID, 'Perfil', 404);
        }
        return response($roleEntity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Core\Domain\RoleEntity  $roleEntity
     * @return \Illuminate\Http\Response
     */
    public function edit(RoleEntity $roleEntity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Core\Domain\RoleEntity  $roleEntity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoleEntity $roleEntity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Core\Domain\RoleEntity  $roleEntity
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleEntity $roleEntity)
    {
        //
    }
}
