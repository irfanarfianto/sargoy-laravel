<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SellerController extends Controller
{
    public function index()
    {
        Log::info('Entering SellerController@index');
        return view('dashboard.seller.index');
    }
}
