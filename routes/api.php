<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\ContactController;


// ── Public routes ──────────────────────────────────────────
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/tags', [TagController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
Route::post('/posts/{id}/likes', [LikeController::class, 'toggle']);


// ── Public routes ──────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
});

// ── Protected routes (any logged-in user) ─────────────────────
Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
        Route::put('/profile', [UserController::class, 'updateProfile']);
        Route::put('/change-password', [UserController::class, 'changePassword']);
    });
});

// ── Admin-only routes ─────────────────────────────────────────
Route::middleware(['auth:api', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'index']);
    Route::get('/users/{user}', [AdminController::class, 'show']);
    Route::put('/users/{user}', [AdminController::class, 'update']);
    Route::delete('/users/{user}', [AdminController::class, 'destroy']);
    Route::patch('/users/{user}/status', [AdminController::class, 'toggleStatus']);
});

// ── Admin only routes ──────────────────────────────────────
Route::middleware(['auth:api', 'admin'])->prefix('admin')->group(function () {

    // Skills
    Route::post('/skills', [SkillController::class, 'store']);
    Route::put('/skills/{skill}', [SkillController::class, 'update']);
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy']);

    // Categories
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // Tags
    Route::post('/tags', [TagController::class, 'store']);
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']);

    // Projects
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);

    // Posts
    Route::get('/posts', [PostController::class, 'adminIndex']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // Comments
    Route::get('/comments', [CommentController::class, 'index']);
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // Contacts
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::patch('/contacts/{contact}/read', [ContactController::class, 'markRead']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);
});