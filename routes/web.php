<?php

use App\Http\Controllers\AdvertisorSliderController;
use App\Http\Controllers\Backend\AboutInsatatuteController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CompanyMenuController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DocumentArchivesController;
use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\MainSliderController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\Backend\SpecializationController;
use App\Http\Controllers\Backend\SupervisorController;
use App\Http\Controllers\Backend\SupportMenuController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\TopicsMenuController;
use App\Http\Controllers\Backend\TracksMenuController;
use App\Http\Controllers\Backend\WebMenuController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);
// لايقاف الديباجر نضيف هذا الكود
app('debugbar')->disable();

//Frontend 
Route::get('/',         [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/index',    [FrontendController::class, 'index'])->name('frontend.index');

Route::get('/pages/{slug}', [FrontendController::class, 'pages'])->name('frontend.pages');
Route::get('/blog-list/{blog?}', [FrontendController::class, 'blog_list'])->name('frontend.blog_list');
Route::get('/blog-tag-list/{slug?}', [FrontendController::class, 'blog_tag_list'])->name('frontend.blog_tag_list');
Route::get('/blog-single/{blog?}', [FrontendController::class, 'blog_single'])->name('frontend.blog_single');


Route::get('/change-language/{locale}',     [LocaleController::class, 'switch'])->name('change.language');



//Backend
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //guest to website 
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [BackendController::class, 'login'])->name('login');
        Route::get('/register', [BackendController::class, 'register'])->name('register');
        Route::get('/lock-screen', [BackendController::class, 'lock_screen'])->name('lock-screen');
        Route::get('/recover-password', [BackendController::class, 'recover_password'])->name('recover-password');
    });

    //uthenticate to website 
    Route::group(['middleware' => ['roles', 'role:admin|supervisor']], function () {
        Route::get('/', [BackendController::class, 'index'])->name('index2');
        Route::get('/index', [BackendController::class, 'index'])->name('index');




        // ==============   Sliders Tab   ==============  //
        Route::post('main_sliders/remove-image', [MainSliderController::class, 'remove_image'])->name('main_sliders.remove_image');
        Route::resource('main_sliders', MainSliderController::class);

        Route::post('advertisor_sliders/remove-image', [AdvertisorSliderController::class, 'remove_image'])->name('advertisor_sliders.remove_image');
        Route::resource('advertisor_sliders', AdvertisorSliderController::class);


        // ==============   Users Tab   ==============  //
        Route::post('customers/remove-image', [CustomerController::class, 'remove_image'])->name('customers.remove_image');
        Route::get('customers/get_customers', [CustomerController::class, 'get_customers'])->name('customers.get_customers');
        Route::resource('customers', CustomerController::class);

        Route::post('supervisors/remove-image', [SupervisorController::class, 'remove_image'])->name('supervisors.remove_image');
        Route::resource('supervisors', SupervisorController::class);

        Route::post('instructor/remove-image', [InstructorController::class, 'remove_image'])->name('instructors.remove_image');
        Route::resource('instructors', InstructorController::class);

        Route::resource('specializations', SpecializationController::class);

        Route::resource('tags', TagController::class);


        // ==============   Menus Tab   ==============  //
        Route::resource('web_menus', WebMenuController::class);
        Route::resource('company_menus', CompanyMenuController::class);
        Route::resource('topics_menus', TopicsMenuController::class);
        Route::resource('tracks_menus', TracksMenuController::class);
        Route::resource('support_menus', SupportMenuController::class);

        // ==============   Pages Tab   ==============  //
        Route::post('pages/remove-image', [PagesController::class, 'remove_image'])->name('pages.remove_image');
        Route::resource('pages', PagesController::class);


        // ==============   Blog/Posts Tab   ==============  //
        Route::post('posts/remove-image', [PostController::class, 'remove_image'])->name('posts.remove_image');
        Route::resource('posts', PostController::class);


        // ==============   Pages Tab   ==============  //
        Route::post('about_instatutes/remove-image', [AboutInsatatuteController::class, 'remove_image'])->name('about_instatutes.remove_image');
        Route::resource('about_instatutes', AboutInsatatuteController::class);

        // ==============   Document Archive Tab   ==============  //

        Route::resource('document_archives', DocumentArchivesController::class);



        // ==============   Site Setting  Tab   ==============  //
        Route::get('site_setting/site_infos', [SiteSettingsController::class, 'show_main_informations'])->name('settings.site_main_infos.show');
        Route::post('site_setting/update_site_info/{id?}', [SiteSettingsController::class, 'update_main_informations'])->name('settings.site_main_infos.update');
        Route::post('site_setting/site_infos/remove-image', [SiteSettingsController::class, 'remove_image'])->name('site_infos.remove_image');

        Route::get('site_setting/site_contacts', [SiteSettingsController::class, 'show_contact_informations'])->name('settings.site_contacts.show');
        Route::post('site_setting/update_site_contact/{id?}', [SiteSettingsController::class, 'update_contact_informations'])->name('settings.site_contacts.update');

        Route::get('site_setting/site_socials', [SiteSettingsController::class, 'show_socail_informations'])->name('settings.site_socials.show');
        Route::post('site_setting/update_site_social/{id?}', [SiteSettingsController::class, 'update_social_informations'])->name('settings.site_socials.update');

        Route::get('site_setting/site_metas', [SiteSettingsController::class, 'show_meta_informations'])->name('settings.site_meta.show');
        Route::post('site_setting/update_site_meta/{id?}', [SiteSettingsController::class, 'update_meta_informations'])->name('settings.site_meta.update');

        // ==============   Admin Acount Tab   ==============  //
        Route::get('account_settings', [BackendController::class, 'account_settings'])->name('account_settings');
        Route::post('admin/remove-image', [BackendController::class, 'remove_image'])->name('remove_image');
        Route::patch('account_settings', [BackendController::class, 'update_account_settings'])->name('update_account_settings');


        // ==============   Theme Icon To Style Website Ready ==============  //
        Route::post('/cookie/create/update', [BackendController::class, 'create_update_theme'])->name('create_update_theme');
    });
});
