<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // check auth here and allow edit and delete links

        $login = Auth::check();
        return Inertia::render('Welcome', [
            'canLogin' => !$login,
            'canRegister' => true,
            'canAdd' => $login,
            'canEdit' => $login,
            'canDelete' => $login
        ]);
    }
}
