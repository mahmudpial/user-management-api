<?php

use App\Http\Controllers\Api\Admin\ProjectManagementController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PremiumProjectController;
use App\Http\Controllers\Api\PricingController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectOrderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SiteSettingsController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\StripeWebhookController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// ── Public routes ──────────────────────────────────────────
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/tags', [TagController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);
Route::post('/contacts', [ContactController::class, 'store'])->middleware('throttle:5,1');
Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
Route::post('/posts/{id}/likes', [LikeController::class, 'toggle']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/pricing', [PricingController::class, 'index']);
Route::get('/settings', [SiteSettingsController::class, 'index']);
Route::get('/premium-projects', [PremiumProjectController::class, 'index']);
Route::get('/premium-projects/{slug}', [PremiumProjectController::class, 'show']);
Route::post('/orders/initiate', [ProjectOrderController::class, 'initiate']);
Route::post('/checkout/session', [PaymentController::class, 'createCheckoutSession'])->middleware('throttle:10,1');
Route::get('/checkout/session/verify', [PaymentController::class, 'verifySession'])->middleware('throttle:30,1');
Route::post('/webhooks/stripe', StripeWebhookController::class)->name('webhooks.stripe');
Route::get('/orders/download/{download_token}', [ProjectOrderController::class, 'download'])
    ->name('premium-projects.download');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware('throttle:6,1')
    ->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
    ->middleware(['auth:sanctum,api', 'throttle:6,1'])
    ->name('verification.send');

// ── Auth routes ──────────────────────────────────────────────
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
    Route::get('/orders', [ProjectManagementController::class, 'orders']);
    Route::patch('/orders/{order}/payment-status', [ProjectManagementController::class, 'updateOrderPayment']);

    Route::get('/premium-projects', [ProjectManagementController::class, 'index']);
    Route::post('/premium-projects', [ProjectManagementController::class, 'store']);
    Route::get('/premium-projects/{project}', [ProjectManagementController::class, 'show']);
    Route::put('/premium-projects/{project}', [ProjectManagementController::class, 'update']);
    Route::patch('/premium-projects/{project}', [ProjectManagementController::class, 'update']);
    Route::delete('/premium-projects/{project}', [ProjectManagementController::class, 'destroy']);
    Route::get('/premium-projects/{project}/pricing-tiers', [ProjectManagementController::class, 'pricingTiers']);
    Route::post('/premium-projects/{project}/pricing-tiers', [ProjectManagementController::class, 'storePricingTier']);
    Route::get('/premium-projects/{project}/pricing-tiers/{tier}', [ProjectManagementController::class, 'showPricingTier']);
    Route::put('/premium-projects/{project}/pricing-tiers/{tier}', [ProjectManagementController::class, 'updatePricingTier']);
    Route::patch('/premium-projects/{project}/pricing-tiers/{tier}', [ProjectManagementController::class, 'updatePricingTier']);
    Route::delete('/premium-projects/{project}/pricing-tiers/{tier}', [ProjectManagementController::class, 'destroyPricingTier']);

    Route::get('/users', [AdminController::class, 'index']);
    Route::get('/users/{user}', [AdminController::class, 'show']);
    Route::put('/users/{user}', [AdminController::class, 'update']);
    Route::delete('/users/{user}', [AdminController::class, 'destroy']);
    Route::patch('/users/{user}/status', [AdminController::class, 'toggleStatus']);

    // Skills
    Route::get('/skills', [SkillController::class, 'index']);
    Route::post('/skills', [SkillController::class, 'store']);
    Route::put('/skills/{skill}', [SkillController::class, 'update']);
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // Tags
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']);

    // Projects
    Route::get('/projects', [ProjectController::class, 'index']);
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

    // Contacts / Messages
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/messages', [ContactController::class, 'index']);
    Route::patch('/contacts/{contact}/read', [ContactController::class, 'markRead']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);
    Route::patch('/messages/{contact}/read', [ContactController::class, 'markRead']);
    Route::delete('/messages/{contact}', [ContactController::class, 'destroy']);

    // Site Settings
    Route::get('/settings', [SiteSettingsController::class, 'index']);
    Route::put('/settings', [SiteSettingsController::class, 'update']);

    // Services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

    // Pricing Plans
    Route::get('/pricing', [PricingController::class, 'index']);
    Route::post('/pricing', [PricingController::class, 'store']);
    Route::put('/pricing/{plan}', [PricingController::class, 'update']);
    Route::delete('/pricing/{plan}', [PricingController::class, 'destroy']);
});
