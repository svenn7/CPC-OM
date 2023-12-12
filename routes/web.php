<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PendingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\MessageController;

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

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'officer') {
            return redirect()->route('officer.dashboard');
        } elseif (auth()->user()->role === 'student') {
            return redirect()->route('student.home');
        }
    }

    // If not authenticated, show the welcome page
    return view('welcome');
});

//Admin Routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/history', [AdminController::class, 'history'])->name('admin.history');
Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
Route::get('/admin/violations', [AdminController::class, 'violations'])->name('admin.violations');
Route::get('/admin/pending', [AdminController::class, 'pending'])->name('admin.pending');
Route::get('/admin/messages', [AdminController::class, 'messages'])->name('admin.messages');
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
Route::get('/admin/officers', [AdminController::class, 'officers'])->name('admin.officers');
Route::get('/admin/report', [AdminController::class, 'reports'])->name('admin.reports');
Route::get('/admin/create-account', [AdminController::class, 'createaccount'])->name('createaccount-account');

//Officer Routes
Route::get('/officer/dashboard', [OfficerController::class, 'dashboard'])->name('officer.dashboard');
Route::get('/officer/history', [OfficerController::class, 'history'])->name('officer.history');
Route::get('/officer/settings', [OfficerController::class, 'settings'])->name('officer.settings');
Route::get('/officer/report', [AdminController::class, 'reports'])->name('officer.reports');

//Student Routes
Route::get('/student/home', [StudentController::class, 'home'])->name('student.home');
Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
Route::get('/student/account', [StudentController::class, 'account'])->name('student.account');
Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');



//Home
Route::get('/dashboard', function () {
    return view('student/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Middlewares
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
});
Route::middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/officer/dashboard', [OfficerController::class, 'OfficerDashboard'])->name('officer.dashboard');
});
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('student/dashboard', [StudentController::class, 'StudentDashboard'])->name('student.home');
});
require __DIR__.'/auth.php';

//CRUD
//violations
Route::resource("/admin/violations", ViolationController::class);
Route::delete('/admin/violations/{violation}', [ViolationController::class, 'destroy'])->name('violations.destroy');

//students
Route::resource("/admin/student", StudentsController::class);
Route::get('/admin/students', [StudentsController::class, 'index'])->name('students.index');
Route::delete('/admin/students/{id}', [StudentsController::class, 'destroy'])->name('students.destroy');
Route::post('/student/profile/{id}', [StudentsController::class, 'updateProfilePicture'])->name('profile.updateProfilePicture');
Route::get('/student/dashboard', [StudentsController::class, 'studentIndex'])->name('dashboard.studentIndex');
Route::get('/student/dashboard', [ReportController::class, 'index'])->name('dashboard.index');
Route::post('/student/account', [StudentsController::class, 'changePassword'])->name('account.changePassword');

//Reports
//Admin
Route::resource('reports', ReportController::class);
Route::get('/admin/report', [ReportController::class, 'violationReports'])->name('report.violationReports');
Route::get('/admin/report', [ReportController::class, 'index'])->name('report.index');
Route::post('/admin/report', [ReportController::class, 'store'])->name('report.store');
Route::get('/admin/report/{idNo}/get-student-name', [ReportController::class, 'getStudentName'])->name('report.getStudentName');
//Officer
Route::resource('reports', ReportController::class);
Route::get('/officer/report', [ReportController::class, 'violationReports'])->name('report.violationReports');
Route::get('/officer/report', [ReportController::class, 'index'])->name('report.index');
Route::post('/officer/report', [ReportController::class, 'store'])->name('report.store');
Route::get('/officer/report/{idNo}/get-student-name', [ReportController::class, 'getStudentName'])->name('report.getStudentName');

//Pending
Route::resource('pending', PendingController::class);
Route::get('/admin/pending', [PendingController::class, 'index'])->name('pending.index');
Route::post('/pending/updateStatus', [PendingController::class, 'updateStatus'])->name('pending.updateStatus');
Route::post('/pending/updateStatusAll', [PendingController::class, 'updateStatusAll'])->name('pending.updateStatusAll');

//Create-Officer
Route::resource('create-account', AccountsController::class);
Route::post('/admin/create-account', [AccountsController::class, 'promoteStudent'])->name('create-account.promoteStudent');
Route::post('/admin/create-officer', [AccountsController::class, 'store'])->name('create-officer.store');
Route::get('/admin/officers', [AccountsController::class, 'index'])->name('officers.index');
Route::delete('/admin/officers/{id}', [AccountsController::class, 'destroy'])->name('officers.destroy');
Route::patch('/admin/officers/{id}', [AccountsController::class, 'restore'])->name('officers.restore');
Route::put('/settings/{id}', [AccountsController::class, 'update'])->name('settings.update');

//Message
Route::resource('create-account', MessageController::class);
Route::post('/admin/messages', [MessageController::class, 'sendMessage'])->name('messages.sendMessage');
Route::get('/admin/messages', [MessageController::class, 'index'])->name('messages.index');
Route::delete('/admin/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
