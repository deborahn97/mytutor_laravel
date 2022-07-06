<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorsAuthController;
use App\Http\Controllers\SubjectsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('privacy-policy', function () {
    return view('privacy_policy');
});

Route::get('subjects-list', function () {
    if (!Auth::guard('tutors')->check()) {
        return redirect('/');
    }
    else {
        $tutor_id = Auth::guard('tutors')->user()->id;
        $subjects = DB::select('SELECT * FROM subjects WHERE tutor_id = ' . $tutor_id);
        return view('subjects_list')->with('listSubjects', $subjects);
    }
});

Route::post('register', [TutorsAuthController::class, 'register'])->name('register');
Route::post('login', [TutorsAuthController::class, 'login'])->name('login');
Route::get('logout', [TutorsAuthController::class, 'logout'])->name('logout');

Route::post('savesubject', [SubjectsController::class,'saveSubjects'])-> name('add-subject');
