<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\NotesController;
Route::get('/', function () {
    return view('welcome');
});



Route::any('/home/{search?}', [ProgramController::class, 'showPrograms'])->name('home');
// Route::post('/home', [ProgramController::class, 'showProgramsbyuser'])->name('home');

// Insert Projects
Route::get('/insertprojectview', [ProgramController::class,'insertProgramsView']);

Route::post('/insertproject', [ProgramController::class,'insertPrograms']);

// Insert Issues
Route::get('insertissueview/{project_id}',[IssueController::class,'showInsertIssueForm'])->name('issueform');
Route::post('insertissue',[IssueController::class,'insertIssueForm']);

//delete
Route::delete('delete/{type}/{id}',[ProgramController::class,'delete']);

//edit project
Route::get('editprojectview/{project_id}',[ProgramController::class,'editprojectview']);
Route::post('editproject',[ProgramController::class,'editproject']);

//editIssue
Route::get('editissueview/{issue_id}',[IssueController::class,'editissueview']);
Route::post('editissue',[IssueController::class,'editissue']);


// Route::post('login',[AuthController::class, 'login']);
Route::any('register', [AuthController::class,'register'])->name('register');
Route::any('login', [AuthController::class,'login'])->name('login');
Route::any('logout', [AuthController::class,'logout'])->name('logout');




Route::post('assign-user',[ProgramController::class,'assignuser']);

Route::any('/image/{issueid}',[ProgramController::class,'showimage']);


Route::any('/showissue/{issue_id}', [IssueController::class,'showissue']);


Route::any ('/insertnotes',[NotesController::class,'insertnotes']);
Route::any('/editnotes/{id_notes}',[NotesController::class,'editnotes']);