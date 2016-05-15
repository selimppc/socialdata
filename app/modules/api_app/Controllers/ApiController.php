<?php

namespace App\Modules\Api_app\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function index()
    {
        return view('api_app::index');
    }
}