<?php


namespace App\Modules\Example\Http\Controllers;


use App\Core\Http\Controllers\Controller;

/**
 * Class IndexController
 * @package App\Modules\Example\Http\Controllers
 */
class IndexController extends Controller
{
    public function index()
    {
        return response(['index.controller'], 200);
    }
}
