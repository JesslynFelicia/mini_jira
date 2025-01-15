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
Route::get('insertissue/{project_id}',[IssueController::class,'showInsertIssueForm'])->name('issueform');
Route::any('insertissue',[IssueController::class,'insertIssueForm']);

//delete
Route::delete('delete/{type}/{id}',[ProgramController::class,'delete']);

//edit project
Route::get('editproject/{project_id}',[ProgramController::class,'editprojectview']);
Route::post('editproject',[ProgramController::class,'editproject']);

//editIssue
Route::get('editissue/{issue_id}',[IssueController::class,'editissueview']);
Route::post('editissue',[IssueController::class,'editissue']);


// Route::post('login',[AuthController::class, 'login']);
Route::any('register', [AuthController::class,'register'])->name('register');
Route::any('login', [AuthController::class,'login'])->name('login');
Route::any('logout', [AuthController::class,'logout'])->name('logout');
Route::any('forgotpassword', [AuthController::class,'forgotpassword'])->name('forgotpassword');




Route::post('assign-user',[ProgramController::class,'assignuser']);

Route::any('/image/{issueid}',[ProgramController::class,'showimage']);


Route::any('/viewissue/{issue_id}', [IssueController::class,'showissue'])->name('issue.viewissue');


Route::any ('/insertnotes',[NotesController::class,'insertnotes']);
Route::any('/editnotes/{id_notes}',[NotesController::class,'editnotes']);


// Route untuk menampilkan semua issue
Route::get('/issues', [IssueController::class, 'showAllIssues'])->name('issue.index');

// Route untuk mengubah status issue menjadi diterima atau ditolak
Route::post('/issues/{id}/{filter}', [IssueController::class, 'updateIssueStatus'])->name('issue.updateStatus');


Route::get('/issues/{filter}', [IssueController::class, 'filter'])->name('issue.filter');;
