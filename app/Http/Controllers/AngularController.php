<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**  
 * UI Controller 
 */
class AngularController extends Controller
{
    public function show()
    {
        return view('angular');
    }
}
