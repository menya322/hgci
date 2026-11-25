<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\GalleryAlbumController as AdminGalleryAlbumController;
use App\Http\Controllers\Admin\GalleryImageController as AdminGalleryImageController;
use App\Http\Controllers\Admin\Inbox\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\Inbox\DonationPledgeController as AdminDonationPledgeController;
use App\Http\Controllers\Admin\Inbox\SponsorshipEnquiryController as AdminSponsorshipEnquiryController;
use App\Http\Controllers\Admin\Inbox\VolunteerApplicationController as AdminVolunteerApplicationController;
use App\Http\Controllers\Admin\InboxController as AdminInboxController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GetInvolvedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SponsorController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/about', AboutController::class)->name('about');

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/impact', ImpactController::class)->name('impact');

Route::get('/sponsor', SponsorController::class)->name('sponsor');
Route::post('/sponsor/enquiry', [SponsorController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('sponsor.enquiry');

Route::get('/donate', DonateController::class)->name('donate');
Route::post('/donate/pledge', [DonateController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('donate.pledge');

Route::get('/get-involved', GetInvolvedController::class)->name('get-involved');
Route::post('/get-involved/volunteer', [GetInvolvedController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('get-involved.volunteer');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{post}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{album}', [GalleryController::class, 'show'])->name('gallery.show');

Route::get('/contact', ContactController::class)->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('login', [AdminLoginController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');

        Route::resource('posts', AdminPostController::class)->except('show');
        Route::resource('programs', AdminProgramController::class)->except('show');
        Route::resource('projects', AdminProjectController::class)->except('show');
        Route::resource('events', AdminEventController::class)->except('show');
        Route::resource('team', AdminTeamMemberController::class)->except('show')->parameters(['team' => 'member']);
        Route::resource('testimonials', AdminTestimonialController::class)->except('show');
        Route::resource('faqs', AdminFaqController::class)->except('show');

        Route::resource('gallery', AdminGalleryAlbumController::class)->except('show')->parameters(['gallery' => 'album']);

        Route::prefix('gallery/{album}/images')
            ->name('gallery.images.')
            ->scopeBindings()
            ->group(function () {
                Route::get('/', [AdminGalleryImageController::class, 'index'])->name('index');
                Route::post('/', [AdminGalleryImageController::class, 'store'])->name('store');
                Route::put('{image}', [AdminGalleryImageController::class, 'update'])->name('update');
                Route::delete('{image}', [AdminGalleryImageController::class, 'destroy'])->name('destroy');
                Route::post('{image}/cover', [AdminGalleryImageController::class, 'cover'])->name('cover');
                Route::post('{image}/move', [AdminGalleryImageController::class, 'move'])->name('move');
            });

        Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');

        Route::get('inbox', AdminInboxController::class)->name('inbox.index');

        Route::get('inbox/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
        Route::get('inbox/messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
        Route::post('inbox/messages/{message}/read', [AdminContactMessageController::class, 'markAsRead'])->name('messages.read');
        Route::delete('inbox/messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('inbox/enquiries', [AdminSponsorshipEnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('inbox/enquiries/export', [AdminSponsorshipEnquiryController::class, 'export'])->name('enquiries.export');
        Route::get('inbox/enquiries/{enquiry}', [AdminSponsorshipEnquiryController::class, 'show'])->name('enquiries.show');
        Route::post('inbox/enquiries/{enquiry}/read', [AdminSponsorshipEnquiryController::class, 'markAsRead'])->name('enquiries.read');
        Route::delete('inbox/enquiries/{enquiry}', [AdminSponsorshipEnquiryController::class, 'destroy'])->name('enquiries.destroy');

        Route::get('inbox/pledges', [AdminDonationPledgeController::class, 'index'])->name('pledges.index');
        Route::get('inbox/pledges/export', [AdminDonationPledgeController::class, 'export'])->name('pledges.export');
        Route::get('inbox/pledges/{pledge}', [AdminDonationPledgeController::class, 'show'])->name('pledges.show');
        Route::post('inbox/pledges/{pledge}/read', [AdminDonationPledgeController::class, 'markAsRead'])->name('pledges.read');
        Route::delete('inbox/pledges/{pledge}', [AdminDonationPledgeController::class, 'destroy'])->name('pledges.destroy');

        Route::get('inbox/applications', [AdminVolunteerApplicationController::class, 'index'])->name('applications.index');
        Route::get('inbox/applications/{application}', [AdminVolunteerApplicationController::class, 'show'])->name('applications.show');
        Route::post('inbox/applications/{application}/read', [AdminVolunteerApplicationController::class, 'markAsRead'])->name('applications.read');
        Route::delete('inbox/applications/{application}', [AdminVolunteerApplicationController::class, 'destroy'])->name('applications.destroy');
    });
});
