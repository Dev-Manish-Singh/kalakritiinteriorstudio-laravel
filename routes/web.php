<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\AdminInquiryController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\InquiryController;

Route::redirect('/login', '/admin');
Route::redirect('/register', '/admin/register');

Route::get('/admin', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/index.html', [AdminDashboardController::class, 'index']);
    Route::get('/index', [AdminDashboardController::class, 'index']);

    Route::get('/banners', [AdminBannerController::class, 'index'])->name('banners');
    Route::post('/banners', [AdminBannerController::class, 'store'])->name('banners.store');
    Route::put('/banners/{banner}', [AdminBannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [AdminBannerController::class, 'destroy'])
        ->whereNumber('banner')
        ->name('banners.destroy');
    Route::delete('/banners/bulk-delete', [AdminBannerController::class, 'bulkDestroy'])->name('banners.bulk-destroy');

    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs');
    Route::post('/blogs', [AdminBlogController::class, 'store'])->name('blogs.store');
    Route::put('/blogs/{blog}', [AdminBlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [AdminBlogController::class, 'destroy'])
        ->whereNumber('blog')
        ->name('blogs.destroy');
    Route::delete('/blogs/bulk-delete', [AdminBlogController::class, 'bulkDestroy'])->name('blogs.bulk-destroy');

    Route::get('/gallery', [AdminGalleryController::class, 'index'])->name('gallery');
    Route::post('/gallery', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::put('/gallery/{gallery}', [AdminGalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{gallery}', [AdminGalleryController::class, 'destroy'])
        ->whereNumber('gallery')
        ->name('gallery.destroy');
    Route::delete('/gallery/bulk-delete', [AdminGalleryController::class, 'bulkDestroy'])->name('gallery.bulk-destroy');
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials');
    Route::post('/testimonials', [AdminTestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [AdminTestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])
        ->whereNumber('testimonial')
        ->name('testimonials.destroy');
    Route::delete('/testimonials/bulk-delete', [AdminTestimonialController::class, 'bulkDestroy'])->name('testimonials.bulk-destroy');
    Route::get('/services', [AdminServiceController::class, 'index'])->name('services');
    Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');
    Route::delete('/services/bulk-delete', [AdminServiceController::class, 'bulkDestroy'])->name('services.bulk-destroy');
    Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects');
    Route::post('/projects', [AdminProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [AdminProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminProjectController::class, 'destroy'])->name('projects.destroy');
    Route::delete('/projects/bulk-delete', [AdminProjectController::class, 'bulkDestroy'])->name('projects.bulk-destroy');
    Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries');
    Route::delete('/inquiries/{inquiry}', [AdminInquiryController::class, 'destroy'])
        ->whereNumber('inquiry')
        ->name('inquiries.destroy');
    Route::delete('/inquiries/bulk-delete', [AdminInquiryController::class, 'bulkDestroy'])->name('inquiries.bulk-destroy');
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::get('/profile', [AdminAuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AdminAuthController::class, 'updatePassword'])->name('profile.password');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::get('/', [BannerController::class, 'index'])->name('home');
Route::get('/index.php', [BannerController::class, 'index']);

Route::view('/about', 'frontend.about')->name('about');
Route::view('/about.php', 'frontend.about');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services.php', [ServiceController::class, 'index']);
Route::get('/service/{service:slug}', [ServiceController::class, 'show'])->name('service.details');
Route::get('/service.php/{service:slug}', [ServiceController::class, 'show']);
Route::redirect('/service', '/services');
Route::redirect('/service.php', '/services');
Route::redirect('/service-details/{service:slug}', '/service/{service:slug}');
Route::redirect('/service-details.php/{service:slug}', '/service/{service:slug}');
Route::redirect('/service-details', '/services');
Route::redirect('/service-details.php', '/services');

Route::get('/project', [ProjectController::class, 'index'])->name('project');
Route::get('/project.php', [ProjectController::class, 'index']);
Route::get('/project-details/{project:slug}', [ProjectController::class, 'show'])->name('project.details');
Route::get('/project-details.php/{project:slug}', [ProjectController::class, 'show']);
Route::redirect('/project-details', '/project');
Route::redirect('/project-details.php', '/project');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery.php', [GalleryController::class, 'index']);

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog.php', [BlogController::class, 'index']);
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.details');
Route::get('/blog-details/{blog:slug}', [BlogController::class, 'show']);
Route::redirect('/blog-details', '/blog');
Route::redirect('/blog-details.php', '/blog');
Route::get('/blog-details.php/{blog:slug}', [BlogController::class, 'show']);

Route::view('/contact', 'frontend.contact')->name('contact');
Route::view('/contact.php', 'frontend.contact');
Route::post('/contact', [InquiryController::class, 'store'])->name('contact.submit');
