<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BidsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ContactDevController;
use App\Http\Controllers\FreelancerDetailsController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Article;
use App\Models\Bids;
use App\Models\Comments;
use App\Models\FreelancerDetails;
use App\Models\Job;
use App\Models\Post;
use App\Models\Projects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function (Request $request) {
    if (!Auth::check()) {
        return view('homepage');
    } else {
        $controller = new PostController();
        return $controller->index($request);
    }
})->name('homepage');

Route::get('/contact', [ContactDevController::class, 'show'])
    ->name('contact.show');
Route::post('/contact', [ContactDevController::class, 'sendMsg'])
    ->name('contact.send');

Route::middleware(['auth'])->group(function () {
    Route::get('/subscription', [SubscriptionController::class, 'show'])
        ->name('subscription.show');
});

// Auth Route
Route::post('/logout', [SessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [SessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [SessionController::class, 'store'])
        ->middleware('throttle:10,1');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email')
        ->middleware('throttle:10,1');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');

    Route::get('/register', [RegisterUserController::class, 'create'])
        ->name('register')
        ->can('create', User::class);

    Route::post('/register', [RegisterUserController::class, 'store'])
        ->name('register.store')
        ->can('create', User::class);

    Route::get('/register/verify', [RegisterUserController::class, 'verify'])
        ->name('auth.verify');

    Route::post('/register/verify', [RegisterUserController::class, 'verifyOtp'])
        ->name('auth.register.verify')
        ->middleware('throttle:10,1');

    Route::post('/register/verify/{user}', [RegisterUserController::class, 'sendVerificationCode'])
        ->name('auth.verify.resend')
        ->middleware('throttle:10,1');
});

// Jobs Route
Route::get('/jobs', [JobController::class, 'index'])
    ->name('jobs.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create'])
        ->name('jobs.create')
        ->can('create', Job::class);

    Route::get('/jobs/{job}', [JobController::class, 'show'])
        ->name('jobs.show');

    Route::post('/jobs', [JobController::class, 'store'])
        ->name('jobs.store')
        ->can('create', Job::class);

    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
        ->name('jobs.edit')
        ->can('update', 'job');

    Route::patch('/jobs/{job}', [JobController::class, 'update'])
        ->name('jobs.update')
        ->can('update', 'job');

    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
        ->name('jobs.destroy')
        ->can('delete', 'job');
});

// Bids
Route::middleware(['auth'])->group(function () {
    Route::get('/jobs/{job}/bids', [BidsController::class, 'index'])
        ->name('bids.index')
        ->can('viewAny', Bids::class);

    Route::post('/jobs/{job}/bids', [BidsController::class, 'store'])
        ->name('bids.store')
        ->can('create', Bids::class);

    Route::get('/jobs/{job}/bids/{bid}', [BidsController::class, 'show'])
        ->name('bids.show')
        ->can('view', ['bid', 'job']);

    Route::get('/jobs/{job}/bids/{bid}/edit', [BidsController::class, 'edit'])
        ->name('bids.edit')
        ->can('update', 'bid');

    Route::patch('/jobs/{job}/bids/{bid}', [BidsController::class, 'update'])
        ->name('bids.update')
        ->can('update', 'bid');

    Route::delete('/jobs/{job}/bids/{bid}', [BidsController::class, 'delete'])
        ->name('bids.delete')
        ->can('delete', ['bid', 'job']);

    Route::patch('/jobs/{job}/bids/{bid}/status', [BidsController::class, 'update_status'])
        ->name('bids.update_status')
        ->can('updateStatus', ['bid', 'job']);

    Route::patch('/jobs/{job}/bids/status/reject', [BidsController::class, 'mass_reject'])
        ->name('bids.mass_reject')
        ->can('massRejectBids', 'job');
});

// Articles Route
Route::get('/articles', [ArticleController::class, 'index'])
    ->name('articles.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])
        ->name('articles.create')
        ->can('create', Article::class);

    Route::post('/articles', [ArticleController::class, 'store'])
        ->name('articles.store')
        ->can('create', Article::class);

    Route::get('/articles/{article}', [ArticleController::class, 'show'])
        ->name('articles.show');

    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])
        ->name('articles.edit')
        ->can('update', 'article');

    Route::patch('/articles/{article}', [ArticleController::class, 'update'])
        ->name('articles.update')
        ->can('update', 'article');

    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
        ->name('articles.destroy')
        ->can('delete', 'article');
});

// Posts Route
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create')
        ->can('create', Post::class);

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store')
        ->can('create', Post::class);

    Route::get('/posts/{post}', [PostController::class, 'show'])
        ->name('posts.show');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit')
        ->can('update', 'post');

    Route::patch('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update')
        ->can('update', 'post');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    // Comments
    Route::post('/comments/{post}', [CommentsController::class, 'store'])
        ->name('comments.store')
        ->can('create', Comments::class);

    // Likes
    Route::post('/posts/{post}/like', [PostLikeController::class, 'store'])->name('posts.like');
});

// Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/{username}', [ProfileController::class, 'show_user'])
        ->name('profile.show.user');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/profile/freelancer', [FreelancerDetailsController::class, 'show'])
        ->name('freelancer.details.show');

    Route::get('/profile/freelancer/{freelancerDetails}', [FreelancerDetailsController::class, 'show_user'])
        ->name('freelancer.details.show.user');

    Route::get('/profile/freelancer/edit', [FreelancerDetailsController::class, 'edit'])
        ->name('freelancer.details.edit')
        ->can('edit', FreelancerDetails::class);

    Route::patch('/profile/freelancer', [FreelancerDetailsController::class, 'update'])
        ->name('freelancer.details.update')
        ->can('edit', FreelancerDetails::class);
});

// projects
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/projects/new', [ProjectsController::class, 'create'])
        ->name('projects.create')
        ->can('create', Projects::class);

    Route::post('/profile/projects', [ProjectsController::class, 'store'])
        ->name('projects.store')
        ->can('create', Projects::class);

    Route::get('/profile/projects/{project}', [ProjectsController::class, 'show'])
        ->name('projects.show');

    Route::get('/profile/projects/{project}/edit', [ProjectsController::class, 'edit'])
        ->name('projects.edit')
        ->can('update', 'project');

    Route::patch('/profile/projects/{project}', [ProjectsController::class, 'update'])
        ->name('projects.update')
        ->can('update', 'project');

    Route::delete('/profile/projects/{project}', [ProjectsController::class, 'destroy'])
        ->name('projects.destroy');
});

Route::get('/{username}/projects/{project}', [ProjectsController::class, 'show_user'])
    ->name('projects.show.user');

// Image Upload and Delete Routes (API endpoints)
Route::middleware(['auth'])->group(function () {
    Route::post('/image/upload', [ImageUploadController::class, 'upload'])->name('image.upload');
    Route::delete('/image/delete', [ImageUploadController::class, 'delete'])->name('image.delete');
});
