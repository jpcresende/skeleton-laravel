<?php

use App\Core\Domain\RoleEntity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run()
    {
        /**
         * INSERT CORE PERMISSIONS
         */
        $arrayPermission = [
            'App\Core\Http\Controllers\AutenticacaoController@logout',
            'App\Core\Http\Controllers\UserController@store',
            'App\Core\Http\Controllers\ModelHasRoleController@store',
            'App\Core\Http\Controllers\ModelHasRoleController@destroy',
            'App\Core\Http\Controllers\ModelHasRoleController@index',
            'App\Core\Http\Controllers\RoleController@index',
        ];
        foreach ($arrayPermission as $strName) {
            DB::table('permissions')->insert([
                'name' => $strName,
                'guard_name' => RoleEntity::GUARD_NAME,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]);
        }

        /**
         * INSERT DEFAULT ROLES
         */
        $arrayRole = [
            'Administrador',
            'Supervisor',
            'Consultor',
        ];
        foreach ($arrayRole as $strName) {
            DB::table('roles')->insert([
                'name' => $strName,
                'guard_name' => RoleEntity::GUARD_NAME,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]);
        }
    }
}
