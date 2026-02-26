<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/' , HomeController::class)->name('home');
Route::get('/courses/{course:slug}' , [CourseController::class , 'show'])
            ->name('courses.show');


Route::group(['middleware' => ['auth']], function () {
    Route::get("/my-courses" ,  [CourseController::class , 'index'])
        ->name('courses.index');
        
    Route::get("/enroll/{course:slug}" ,  [CourseController::class , 'enroll'])
        ->name('courses.enroll');

    Route::get('/courses/{course:slug}/play/{lesson:slug?}' , [CourseController::class , 'play'])
        ->name('courses.play');

    Route::post('/lessons/progress', [\App\Http\Controllers\LessonProgressController::class, 'updateProgress'])
        ->name('lessons.progress.update');
});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
