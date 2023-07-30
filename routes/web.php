<?php

use App\Http\Controllers\authcontroller;
use App\Http\Controllers\feedController;
use App\Http\Controllers\HisController;
use App\Http\Controllers\proController;
use App\Http\Controllers\taskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



/*
Route::get('/Da', function () {
    return view('Projet.Show_pro');
});
Route::get('/home', function () {
    return view('index');
});*/
Route::middleware("guest")->group(function(){

 Route::get('/login',[authcontroller::class,'show'])->name('login');
 Route::post('/login',[authcontroller::class,'login'])->name('login.user');
 Route::get('/register',[authcontroller::class,'create'])->name('register');
 Route::post('/register',[authcontroller::class,'register'])->name('register.user');

});
Route::middleware("auth")->group(function(){
    Route::fallback(function(){
        return view('Error');
    });
    
    Route::get('/storage-link',function(){
        $targetFolder=storage_path('app/public');
        $linkFolder=$_SERVER['DOCUMENT_ROOT'].'/storage';
        symlink($targetFolder,$linkFolder);
    });

    Route::get('/',[UserController::class,'home'])->name('home');


    //user
    Route::get('/User/create',[UserController::class,'show_create'])->name('user.create');
    Route::post('/User/create',[UserController::class,'create'])->name('user.insert');
    Route::get('/User',[UserController::class,'index'])->name('user.all');
    Route::get('/User/trash',[UserController::class,'show_trash'])->name('user.trash');
    Route::post('/User/{id}/restore',[UserController::class,'restore'])->name('user.restore');
    Route::post('/User/{id}/delete',[UserController::class,'delete'])->name('user.delete');
    Route::get('/User/{id}',[UserController::class,'show'])->name('user.show');
    Route::get('/User/{id}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::post('/User/{id}/edit',[UserController::class,'update'])->name('user.update');
    Route::get('/User/{id}/time',[UserController::class,'get_time'])->name('user.time');


    //auth
    Route::post('/logout',[authcontroller::class,'logout'])->name('logout');
    Route::get('/profile',[authcontroller::class,'index'])->name('profile');
    Route::post('/profile/update', [authcontroller::class, 'updateProfile'])->name('profile.update');


    //task
    Route::get('/task/todo',[taskController::class,'todo'])->name('todo');
    Route::get('/task/create',[taskController::class,'create'])->name('task.create');
    Route::post('/task/create',[taskController::class,'insert'])->name('task.insert');
    Route::get('/task',[taskController::class,'show_all'])->name('task.all');
    Route::get('/task/{id}/edit',[taskController::class,'show_edit'])->name('task.edit');
    Route::post('/task/{id}/edit',[taskController::class,'update'])->name('task.update');
    Route::post('/task/{id}/delete',[taskController::class,'destroy'])->name('task.delete');
    Route::post('task/edit/etat',[taskController::class,'edit_task_etat'])->name('task.edit.etat');
    Route::post('/task/{id}/detach',[taskController::class,'detach'])->name('task.detach');
    Route::get('task/trash',[taskController::class,'show_trash'])->name('task.trash');
    Route::get('/task/{id}',[taskController::class,'show'])->name('task.show');
    Route::post('/task/{id}/restore',[taskController::class,'restore'])->name('task.restore');
    Route::post('task/{id}/edit/emp',[taskController::class,'edit_task_emp'])->name('task.edit.emp');


    //Project
    Route::get('/project/create',[proController::class,'create'])->name('project.create');
    Route::post('/project/create',[proController::class,'insert'])->name('project.insert');
    Route::get('/project',[proController::class,'show_all'])->name('project.all');
    Route::get('/project/{id}/edit',[proController::class,'show_edit'])->name('project.edit');
    Route::post('/project/{id}/edit',[proController::class,'update'])->name('project.update');
    Route::post('/project/{id}/delete',[proController::class,'delete'])->name('project.delete');
    Route::get('/project/trash', [proController::class, 'show_trash'])->name('project.trash');
    Route::post('/project/{id}/restore', [proController::class, 'restore'])->name('project.restore');
    Route::get('/project/{id}',[proController::class,'show'])->name('project.show');
    Route::get('/project/{id}/employee',[proController::class,'get_empl'])->name('project.emplo');


    //feedback
    Route::post('/feedback/add',[feedController::class,'add'])->name('feedback.add');
    Route::get('/feedback',[feedController::class,'get_feed_back'])->name('feedback');


    //history
    Route::get('/history/project',[HisController::class,'history_pro'])->name('history.project');
    Route::get('/history/task',[HisController::class,'history_task'])->name('history.task');
    Route::get('/history/User',[HisController::class,'history_User'])->name('history.User');


});




