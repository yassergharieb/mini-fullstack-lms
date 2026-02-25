<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {

        $courses = Course::with('level')->paginate(10);
        return view('home' , compact('courses'));
    }
}
