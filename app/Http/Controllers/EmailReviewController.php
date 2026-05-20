<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailReviewController extends Controller
{
    public function store(Request $request)
    {
        dd($request->reservation_id);
    }

    public function update()
    {

    }
}
