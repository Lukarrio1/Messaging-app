<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\json;

class ActiveController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $active = User::where([['active', '=', 1], ['id', '!=', $id]])
            ->get();
        return $active;
    }

    public function from($id)
    {
        $from = User::find($id);
        return $from;
    }
}
