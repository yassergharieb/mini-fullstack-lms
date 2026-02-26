<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $levels = Level::all();

        $courses = Course::query()
            ->with('level')
            ->when($request->filled('search'), function ($query) use ($request) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
                });
            })
            ->when($request->filled('level'), function ($query) use ($request) {
                $selectedLevels = is_array($request->level) ? $request->level : [$request->level];
                $query->whereHas('level', function ($q) use ($selectedLevels) {
                    $q->whereIn('slug', $selectedLevels)->orWhereIn('name', $selectedLevels);
                });
            })
            ->paginate(10)
            ->withQueryString();
        
        $enrolledCourseIds = [];
        if (auth()->check()) {
            $enrolledCourseIds = auth()->user()->enrollments()->pluck('course_id')->toArray();
        }

        return view('home' , compact('courses', 'enrolledCourseIds', 'levels'));
    }
}
