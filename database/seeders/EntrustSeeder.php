<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Dictionary : 
     *              01- Roles 
     *              02- Users
     *              03- AttachRoles To  Users
     *              04- Create random customer and  AttachRole to customerRole
     * 
     * 
     * @return void
     */
    public function run()
    {

        //create fake information  using faker factory lab 
        $faker = Factory::create();


        //------------- 01- Roles ------------//
        //adminRole
        $adminRole = new Role();
        $adminRole->name         = 'admin';
        $adminRole->display_name = 'User Administrator'; // optional
        $adminRole->description  = 'User is allowed to manage and edit other users'; // optional
        $adminRole->allowed_route = 'admin';
        $adminRole->save();

        //supervisorRole
        $supervisorRole = Role::create([
            'name' => 'supervisor',
            'display_name' => 'User Supervisor',
            'description' => 'Supervisor is allowed to manage and edit other users',
            'allowed_route' => 'admin',
        ]);


        //customerRole
        $customerRole = new Role();
        $customerRole->name         = 'customer';
        $customerRole->display_name = 'Project Customer'; // optional
        $customerRole->description  = 'Customer is the customer of a given project'; // optional
        $customerRole->allowed_route = null;
        $customerRole->save();


        //------------- 02- Users  ------------//
        // Create Admin
        $admin = new User();
        $admin->first_name = 'Admin';
        $admin->last_name = 'System';
        $admin->username = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->email_verified_at = now();
        $admin->mobile = '00967772036131';
        $admin->password = bcrypt('123123123');
        $admin->user_image = 'avator.svg';
        $admin->status = 1;
        $admin->remember_token = Str::random(10);
        $admin->save();

        // Create supervisor
        $supervisor = User::create([
            'first_name' => 'Supervisor',
            'last_name' => 'System',
            'username' => 'supervisor',
            'email' => 'supervisor@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036132',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        // Create customer
        $customer = User::create([
            'first_name' => 'Khaleel',
            'last_name' => 'Raweh',
            'username' => 'khaleel',
            'email' => 'khaleelvisa@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036133',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        //------------- 03- AttachRoles To  Users  ------------//
        $admin->attachRole($adminRole);
        $supervisor->attachRole($supervisorRole);
        $customer->attachRole($customerRole);


        //------------- 04-  Create random customer and  AttachRole to customerRole  ------------//
        for ($i = 1; $i <= 20; $i++) {
            //Create random customer
            $random_customer = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->email,
                'email_verified_at' => now(),
                'mobile' => '0096777' . $faker->numberBetween(1000000, 9999999),
                'password' => bcrypt('123123123'),
                'user_image' => 'avator.svg',
                'status' => 1,
                'remember_token' => Str::random(10),
            ]);

            //Add customerRole to RandomCusomer
            $random_customer->attachRole($customerRole);
        } //end for


        //------------- 05- Permission  ------------//
        //manage main dashboard page
        $manageMain = Permission::create(['name' => 'main', 'display_name' => 'الرئيسية', 'route' => 'index', 'module' => 'index', 'as' => 'index', 'icon' => 'ri-dashboard-line', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '1']);
        $manageMain->parent_show = $manageMain->id;
        $manageMain->save();


        //Customers
        $manageCustomers = Permission::create(['name' => 'manage_customers', 'display_name' => ['ar'    =>  'إدارة المستخدمين',  'en' =>  'Manage Users'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user-cog', 'parent' => '0', 'parent_original' => '0',  'sidebar_link' => '1', 'appear' => '1', 'ordering' => '20',]);
        $manageCustomers->parent_show = $manageCustomers->id;
        $manageCustomers->save();
        $showCustomers   =  Permission::create(['name'  => 'show_customers', 'display_name'    => ['ar'   =>     'الطلاب',   'en'    =>  'Stduents'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user-graduate', 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createCustomers =  Permission::create(['name'  => 'create_customers', 'display_name'    => ['ar'   =>      'إضافة طالب',   'en'    =>  'Add New Student'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.create', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayCustomers =  Permission::create(['name' => 'display_customers', 'display_name'     => ['ar'   =>      'عرض طالب',   'en'    =>  'Dsiplay Student'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.show', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateCustomers  =  Permission::create(['name' => 'update_customers', 'display_name'     => ['ar'   =>      'تعديل طالب',   'en'    =>  'Edit Student'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.edit', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteCustomers =  Permission::create(['name'  => 'delete_customers', 'display_name'    => ['ar'   =>      'حذف طالب',   'en'    =>  'Delete Student'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.destroy', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Supervisor // we can hide suppervisor not to be in sidebar linke by  making in manage_supervisors 'sidebar_link' => '0'
        $manageSupervisors = Permission::create(['name' => 'manage_supervisors', 'display_name' => ['ar'    =>  'المشرفين',    'en'    =>  'Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageCustomers->id, 'parent_original' => '0', 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '25',]);
        $manageSupervisors->parent_show = $manageSupervisors->id;
        $manageSupervisors->save();
        $showSupervisors   =  Permission::create(['name' => 'show_supervisors', 'display_name'    =>  ['ar'   =>  'المشرفين',   'en'    =>  'Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createSupervisors =  Permission::create(['name' => 'create_supervisors', 'display_name'    =>  ['ar'   =>  'إضافة مشرف جديد',   'en'    =>  'Add Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.create', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displaySupervisors =  Permission::create(['name' => 'display_supervisors', 'display_name'    =>  ['ar'   =>  'عرض مشرف',   'en'    =>  'Dsiplay Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.show', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateSupervisors  =  Permission::create(['name' => 'update_supervisors', 'display_name'    =>  ['ar'   =>  'تعديل مشرف',   'en'    =>  'Edit Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.edit', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteSupervisors =  Permission::create(['name' => 'delete_supervisors', 'display_name'    =>  ['ar'   =>  'حذف مشرف',   'en'    =>  'Delete Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.destroy', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);

        //instructors
        $manageInstructors = Permission::create(['name' => 'manage_instructors', 'display_name' => ['ar'    =>  'المحاضرين',    'en'    =>  'instructors'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.index', 'icon' => 'fas fa-chalkboard-teacher', 'parent' => $manageCustomers->id, 'parent_original' => '0', 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '30',]);
        $manageInstructors->parent_show = $manageInstructors->id;
        $manageInstructors->save();
        $showInstructors   =  Permission::create(['name' => 'show_instructors', 'display_name'    =>  ['ar'   =>  'المحاضرين',   'en'    =>  'instructors'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.index', 'icon' => 'fas fa-chalkboard-teacher', 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createInstructors =  Permission::create(['name' => 'create_instructors', 'display_name'    =>  ['ar'   =>  'إضافة محاضر جديد',   'en'    =>  'Add Instructor'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.create', 'icon' => null, 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayInstructors =  Permission::create(['name' => 'display_instructors', 'display_name'    =>  ['ar'   =>  'عرض محاضر',   'en'    =>  'Dsiplay Instructor'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.show', 'icon' => null, 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateInstructors  =  Permission::create(['name' => 'update_instructors', 'display_name'    =>  ['ar'   =>  'تعديل محاضر',   'en'    =>  'Edit Instructor'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.edit', 'icon' => null, 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteInstructors =  Permission::create(['name' => 'delete_instructors', 'display_name'    =>  ['ar'   =>  'حذف محاضر',   'en'    =>  'Delete Instructor'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.destroy', 'icon' => null, 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '0', 'appear' => '0']);

        //specialization
        $manageSpecializations = Permission::create(['name' => 'manage_specializations', 'display_name' => ['ar'    =>  'التخصصات',    'en'    =>  'specializations'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.index', 'icon' => 'fas fa-file-signature', 'parent' => $manageCustomers->id, 'parent_original' => '0', 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '35',]);
        $manageSpecializations->parent_show = $manageSpecializations->id;
        $manageSpecializations->save();
        $showSpecializations   =  Permission::create(['name' => 'show_specializations', 'display_name'    =>  ['ar'   =>  'التخصصات',   'en'    =>  'specializations'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.index', 'icon' => 'fas fa-file-signature', 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createSpecializations =  Permission::create(['name' => 'create_specializations', 'display_name'    =>  ['ar'   =>  'إضافة تخصص جديد',   'en'    =>  'Add specialization'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.create', 'icon' => null, 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displaySpecializations =  Permission::create(['name' => 'display_specializations', 'display_name'    =>  ['ar'   =>  'عرض تخصص',   'en'    =>  'Dsiplay specialization'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.show', 'icon' => null, 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateSpecializations  =  Permission::create(['name' => 'update_specializations', 'display_name'    =>  ['ar'   =>  'تعديل تخصص',   'en'    =>  'Edit specialization'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.edit', 'icon' => null, 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteSpecializations =  Permission::create(['name' => 'delete_specializations', 'display_name'    =>  ['ar'   =>  'حذف تخصص',   'en'    =>  'Delete specialization'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.destroy', 'icon' => null, 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '0', 'appear' => '0']);



        //main sliders
        $manageMainSliders = Permission::create(['name' => 'manage_main_sliders', 'display_name' => ['ar'    =>  'إدارة عارض الشرائح', 'en' =>  'Manage Slide Viewer'], 'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.index', 'icon' => 'fas fa-sliders-h', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '75',]);
        $manageMainSliders->parent_show = $manageMainSliders->id;
        $manageMainSliders->save();
        $showMainSliders    =  Permission::create(['name' => 'show_main_sliders', 'display_name'    =>  ['ar'    =>  ' عارض الشرائح الرئيسي',   'en'    =>  'Main Slide Viewer'], 'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.index', 'icon' => 'fas  fa-sliders-h', 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createMainSliders  =  Permission::create(['name' => 'create_main_sliders', 'display_name'    =>  ['ar'    =>  'إضافة شريحة جديد',   'en'    =>  'Add Slide'], 'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.create', 'icon' => null, 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayMainSliders =  Permission::create(['name' => 'display_main_sliders', 'display_name'    =>  ['ar'    =>  'عرض الشريحة',   'en'    =>  'Display Main Slide'],  'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.show', 'icon' => null, 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateMainSliders  =  Permission::create(['name' => 'update_main_sliders', 'display_name'    =>  ['ar'    =>  'تعديل الشريحة',   'en'    =>  'Edit Main Slide'],  'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.edit', 'icon' => null, 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteMainSliders  =  Permission::create(['name' => 'delete_main_sliders', 'display_name'    =>  ['ar'    =>  'حذف الشريحة',   'en'    =>  'Delete Main Slide'],  'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.destroy', 'icon' => null, 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Advertisor sliders
        $manageAdvertisorSliders = Permission::create(['name' => 'manage_advertisor_sliders', 'display_name' => ['ar'    =>  'عارض شرائح الإعلانات', 'en'   =>  'Adv Slide Viewer'], 'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.index', 'icon' => 'fas fa-bullhorn', 'parent' => $manageMainSliders->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '80',]);
        $manageAdvertisorSliders->parent_show = $manageAdvertisorSliders->id;
        $manageAdvertisorSliders->save();
        $showAdvertisorSliders    =  Permission::create(['name' => 'show_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'عارض شرائح الإعلانات',   'en'    =>  'Adv Slide Viewer'], 'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.index', 'icon' => 'fas fa-bullhorn', 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createAdvertisorSliders  =  Permission::create(['name' => 'create_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'إضافة شريحة جديد',   'en'    =>  'Add Adv Slide'], 'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.create', 'icon' => null, 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayAdvertisorSliders =  Permission::create(['name' => 'display_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'عرض الشريحة',   'en'    =>  'Display Adv Slide'],  'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.show', 'icon' => null, 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateAdvertisorSliders  =  Permission::create(['name' => 'update_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'تعديل الشريحة',   'en'    =>  'Edit Adv Slide'],  'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.edit', 'icon' => null, 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteAdvertisorSliders  =  Permission::create(['name' => 'delete_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'حذف الشريحة',   'en'    =>  'Delete Adv Slide'],  'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.destroy', 'icon' => null, 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '0', 'appear' => '0']);




        //web menus 
        $manageWebMenus = Permission::create(['name' => 'manage_web_menus', 'display_name' => ['ar' => 'إدارة القوائم', 'en' => 'Manage Menus'], 'route' => 'web_menus', 'module' => 'web_menus', 'as' => 'web_menus.index', 'icon' => 'fa fa-list-ul', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '85',]);
        $manageWebMenus->parent_show = $manageWebMenus->id;
        $manageWebMenus->save();
        $showWebMenus    =  Permission::create(['name' => 'show_web_menus',  'display_name' => ['ar'     => 'إدارة القائمة الرئيسية', 'en'  =>   'Main Menu'], 'route' => 'web_menus', 'module' => 'web_menus', 'as' => 'web_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageWebMenus->id, 'parent_original' => $manageWebMenus->id, 'parent_show' => $manageWebMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createWebMenus  =  Permission::create(['name' => 'create_web_menus', 'display_name'  => ['ar'     => 'إضافة رابط', 'en'  =>  'Add Link'], 'route' => 'web_menus', 'module' => 'web_menus', 'as' => 'web_menus.create', 'icon' => null, 'parent' => $manageWebMenus->id, 'parent_original' => $manageWebMenus->id, 'parent_show' => $manageWebMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayWebMenus =  Permission::create(['name' => 'display_web_menus', 'display_name'  => ['ar'     => 'عرض رابط', 'en'  =>  'Display Link'], 'route' => 'web_menus', 'module' => 'web_menus', 'as' => 'web_menus.show', 'icon' => null, 'parent' => $manageWebMenus->id, 'parent_original' => $manageWebMenus->id, 'parent_show' => $manageWebMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateWebMenus  =  Permission::create(['name' => 'update_web_menus', 'display_name'  => ['ar'     => 'تعديل رابط', 'en'  =>  'Edit Link'], 'route' => 'web_menus', 'module' => 'web_menus', 'as' => 'web_menus.edit', 'icon' => null, 'parent' => $manageWebMenus->id, 'parent_original' => $manageWebMenus->id, 'parent_show' => $manageWebMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteWebMenus  =  Permission::create(['name' => 'delete_web_menus', 'display_name'  => ['ar'     => 'حذف رابط', 'en'  =>  'Delete Link'], 'route' => 'web_menus', 'module' => 'web_menus', 'as' => 'web_menus.destroy', 'icon' => null, 'parent' => $manageWebMenus->id, 'parent_original' => $manageWebMenus->id, 'parent_show' => $manageWebMenus->id, 'sidebar_link' => '0', 'appear' => '0']);


        //company menu
        $manageCompanyMenu = Permission::create(['name' => 'manage_company_menus', 'display_name' => ['ar'    =>  'إدارة قائمة المؤسسة', 'en'   =>  'Company Menu'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageWebMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '90',]);
        $manageCompanyMenu->parent_show = $manageCompanyMenu->id;
        $manageCompanyMenu->save();
        $showCompanyMenu    =  Permission::create(['name' => 'show_company_menus',  'display_name' => ['ar'  =>  'إدارة قوائم المؤسسة',   'en'    =>  'Manage Company Menu'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createCompanyMenu  =  Permission::create(['name' => 'create_company_menus', 'display_name'  => ['ar'  =>  ' إضافة قائمة مؤسسة',   'en'    =>  'Add Company Menu Link'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.create', 'icon' => null, 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayCompanyMenu =  Permission::create(['name' => 'display_company_menus', 'display_name'  => ['ar'  =>  'عرض قائمة مؤسسة',   'en'    =>  'Display Company Menu Link'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.show', 'icon' => null, 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateCompanyMenu  =  Permission::create(['name' => 'update_company_menus', 'display_name'  => ['ar'  =>  'تعديل قائمة مؤسسة',   'en'    =>  'Edit Company Menu Link'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.edit', 'icon' => null, 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteCompanyMenu  =  Permission::create(['name' => 'delete_company_menus', 'display_name'  => ['ar'  =>  'حذف قائمة مؤسسة',   'en'    =>  'Delete Company Menu Link'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.destroy', 'icon' => null, 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Topics menu
        $manageTopicsMenus = Permission::create(['name' => 'manage_topics_menus', 'display_name' => ['ar'    =>  'إدارة قائمة المواضيع', 'en'   =>  'Topics Menu'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageWebMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '95',]);
        $manageTopicsMenus->parent_show = $manageTopicsMenus->id;
        $manageTopicsMenus->save();
        $showTopicsMenus    =  Permission::create(['name' => 'show_topics_menus',  'display_name' => ['ar'  =>  'إدارة قائمة المواضيع',   'en'    =>  'Topics Menu'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createTopicsMenus  =  Permission::create(['name' => 'create_topics_menus', 'display_name'  => ['ar'  =>  'إضافة قائمة موضوع',   'en'    =>  'Add Topic Menu Link'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.create', 'icon' => null, 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayTopicsMenus =  Permission::create(['name' => 'display_topics_menus', 'display_name'  => ['ar'  =>  'عرض قائمة موضوع',   'en'    =>  'Display Topic Menu Link'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.show', 'icon' => null, 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateTopicsMenus  =  Permission::create(['name' => 'update_topics_menus', 'display_name'  => ['ar'  =>  'تعديل قائمة موضوع',   'en'    =>  'Edit Topic Menu Link'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.edit', 'icon' => null, 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteTopicsMenus  =  Permission::create(['name' => 'delete_topics_menus', 'display_name'  => ['ar'  =>  'حذف قائمة موضوع',   'en'    =>  'Delete Topic Menu Link'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.destroy', 'icon' => null, 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Tracks menu
        $manageTracksMenus = Permission::create(['name' => 'manage_tracks_menus', 'display_name' => ['ar'    =>  'إدارة قائمة المسارات', 'en'   =>  'Tracks Menu'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageWebMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '100',]);
        $manageTracksMenus->parent_show = $manageTracksMenus->id;
        $manageTracksMenus->save();
        $showTracksMenus    =  Permission::create(['name' => 'show_tracks_menus',  'display_name' => ['ar'  =>  'إدارة قائمة المسارات',   'en'    =>  'Tracks Menu'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createTracksMenus  =  Permission::create(['name' => 'create_tracks_menus', 'display_name'  => ['ar'  =>  'إضافة قائمة مسار',   'en'    =>  'Add Track Menu Link'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.create', 'icon' => null, 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayTracksMenus =  Permission::create(['name' => 'display_tracks_menus', 'display_name'  => ['ar'  =>  'عرض قائمة مسار',   'en'    =>  'Display Track Menu Link'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.show', 'icon' => null, 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateTracksMenus  =  Permission::create(['name' => 'update_tracks_menus', 'display_name'  => ['ar'  =>  'تعديل قائمة مسار',   'en'    =>  'Edit Track Menu Link'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.edit', 'icon' => null, 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteTracksMenus  =  Permission::create(['name' => 'delete_tracks_menus', 'display_name'  => ['ar'  =>  'حذف قائمة مسار',   'en'    =>  'Delete Track Menu Link'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.destroy', 'icon' => null, 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Support menu
        $manageSupportMenus = Permission::create(['name' => 'manage_support_menus', 'display_name' => ['ar'    =>  'إدارة قائمة الدعم', 'en'   =>  'Support Menu'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageWebMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '105',]);
        $manageSupportMenus->parent_show = $manageSupportMenus->id;
        $manageSupportMenus->save();
        $showSupportMenus    =  Permission::create(['name' => 'show_support_menus',  'display_name' => ['ar'  =>  'إدارة قائمة الدعم',   'en'    =>  'Support Menu'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createSupportMenus  =  Permission::create(['name' => 'create_support_menus', 'display_name'  => ['ar'  =>  'إضافة قامة دعم',   'en'    =>  'Add Support Menu Link'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.create', 'icon' => null, 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displaySupportMenus =  Permission::create(['name' => 'display_support_menus', 'display_name'  => ['ar'  =>  'عرض قامة دعم',   'en'    =>  'Display Support Menu Link'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.show', 'icon' => null, 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateSupportMenus  =  Permission::create(['name' => 'update_support_menus', 'display_name'  => ['ar'  =>  'تعديل قامة دعم',   'en'    =>  'Edit Support Menu Link'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.edit', 'icon' => null, 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteSupportMenus  =  Permission::create(['name' => 'delete_support_menus', 'display_name'  => ['ar'  =>  'حذف قامة دعم',   'en'    =>  'Delete Support Menu Link'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.destroy', 'icon' => null, 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '0', 'appear' => '0']);

        //web menu helper
        $manageWebMenuHelps = Permission::create(['name' => 'manage_web_menu_helps', 'display_name' => ['ar'    =>  'إدارة قائمة المساعدة', 'en'   =>  'Helps Menu'], 'route' => 'web_menu_helps', 'module' => 'web_menu_helps', 'as' => 'web_menu_helps.index', 'icon' => 'fa fa-question', 'parent' => $manageWebMenus->id, 'parent_original' => '0', 'sidebar_link' => '0', 'appear' => '0', 'ordering' => '110',]);
        $manageWebMenuHelps->parent_show = $manageWebMenuHelps->id;
        $manageWebMenuHelps->save();
        $showWebMenuHelps    =  Permission::create(['name' => 'show_web_menu_helps',  'display_name' => ['ar'  =>  'إدارة قوائم المساعدة',   'en'    =>  'Helps Menu'], 'route' => 'web_menu_helps', 'module' => 'web_menu_helps', 'as' => 'web_menu_helps.index', 'icon' => 'fa fa-question', 'parent' => $manageWebMenuHelps->id, 'parent_original' => $manageWebMenuHelps->id, 'parent_show' => $manageWebMenuHelps->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createWebMenuHelps  =  Permission::create(['name' => 'create_web_menu_helps', 'display_name'  => ['ar'  =>  'إضافة قائمة مساعدة',   'en'    =>  'Add Help Menu Link'], 'route' => 'web_menu_helps', 'module' => 'web_menu_helps', 'as' => 'web_menu_helps.create', 'icon' => null, 'parent' => $manageWebMenuHelps->id, 'parent_original' => $manageWebMenuHelps->id, 'parent_show' => $manageWebMenuHelps->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayWebMenuHelps =  Permission::create(['name' => 'display_web_menu_helps', 'display_name'  => ['ar'  =>  'عرض قائمة مساعدة',   'en'    =>  'Display Help Menu Link'], 'route' => 'web_menu_helps', 'module' => 'web_menu_helps', 'as' => 'web_menu_helps.show', 'icon' => null, 'parent' => $manageWebMenuHelps->id, 'parent_original' => $manageWebMenuHelps->id, 'parent_show' => $manageWebMenuHelps->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateWebMenuHelps  =  Permission::create(['name' => 'update_web_menu_helps', 'display_name'  => ['ar'  =>  'تعديل قائمة مساعدة',   'en'    =>  'Edit Help Menu Link'], 'route' => 'web_menu_helps', 'module' => 'web_menu_helps', 'as' => 'web_menu_helps.edit', 'icon' => null, 'parent' => $manageWebMenuHelps->id, 'parent_original' => $manageWebMenuHelps->id, 'parent_show' => $manageWebMenuHelps->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteWebMenuHelps  =  Permission::create(['name' => 'delete_web_menu_helps', 'display_name'  => ['ar'  =>  'حذف قائمة مساعدة',   'en'    =>  'Delete Help Menu Link'], 'route' => 'web_menu_helps', 'module' => 'web_menu_helps', 'as' => 'web_menu_helps.destroy', 'icon' => null, 'parent' => $manageWebMenuHelps->id, 'parent_original' => $manageWebMenuHelps->id, 'parent_show' => $manageWebMenuHelps->id, 'sidebar_link' => '0', 'appear' => '0']);


        //pages 
        $managePages = Permission::create(['name' => 'manage_pages', 'display_name' => ['ar' => 'إدارة الصفحات', 'en' => 'Manage Pages'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.index', 'icon' => 'far fa-file-alt', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '115',]);
        $managePages->parent_show = $managePages->id;
        $managePages->save();
        $showPages    =  Permission::create(['name' => 'show_pages',  'display_name' => ['ar'     => 'إدارة الصفحة ', 'en'  =>   'Main Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.index', 'icon' => 'far fa-file-alt', 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createPages  =  Permission::create(['name' => 'create_pages', 'display_name'  => ['ar'     => 'إضافة صفحة', 'en'  =>  'Add Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.create', 'icon' => null, 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayPages =  Permission::create(['name' => 'display_pages', 'display_name'  => ['ar'     => 'عرض صفحة', 'en'  =>  'Display Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.show', 'icon' => null, 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePages  =  Permission::create(['name' => 'update_pages', 'display_name'  => ['ar'     => 'تعديل صفحة', 'en'  =>  'Edit Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.edit', 'icon' => null, 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePages  =  Permission::create(['name' => 'delete_pages', 'display_name'  => ['ar'     => 'حذف صفحة', 'en'  =>  'Delete Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.destroy', 'icon' => null, 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);


        // posts
        $managePosts = Permission::create(['name' => 'manage_posts', 'display_name' => ['ar'  =>  'إدارة المدونة',    'en'    =>  'Manage Blogs'], 'route' => 'posts', 'module' => 'posts', 'as' => 'posts.index', 'icon' => 'fas fas fa-newspaper', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '70',]);
        $managePosts->parent_show = $managePosts->id;
        $managePosts->save();
        $showPosts   =  Permission::create(['name'  => 'show_posts', 'display_name'       =>  ['ar'   =>  'المنشورات',   'en'    =>  'Posts'], 'route' => 'posts', 'module' => 'posts', 'as' => 'posts.index', 'icon' => 'fas fas fa-newspaper', 'parent' => $managePosts->id, 'parent_original' => $managePosts->id, 'parent_show' => $managePosts->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createPosts =  Permission::create(['name'  => 'create_posts', 'display_name'     =>  ['ar'   =>  'إنشاء منشور',   'en'    =>  'Create Post'], 'route' => 'posts/create', 'module' => 'posts', 'as' => 'posts.create', 'icon' => null, 'parent' => $managePosts->id, 'parent_original' => $managePosts->id, 'parent_show' => $managePosts->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayPosts =  Permission::create(['name' => 'display_posts', 'display_name'    =>  ['ar'   =>  'عرض منشرو',   'en'    =>  'Display Post'], 'route' => 'posts/{posts}', 'module' => 'posts', 'as' => 'posts.show', 'icon' => null, 'parent' => $managePosts->id, 'parent_original' => $managePosts->id, 'parent_show' => $managePosts->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePosts  =  Permission::create(['name' => 'update_posts', 'display_name'     =>  ['ar'   =>  'تعديل منشور',   'en'    =>  'Edit Post'], 'route' => 'posts/{posts}/edit', 'module' => 'posts', 'as' => 'posts.edit', 'icon' => null, 'parent' => $managePosts->id, 'parent_original' => $managePosts->id, 'parent_show' => $managePosts->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePosts =  Permission::create(['name'  => 'delete_posts', 'display_name'     =>  ['ar'   =>  'حذف منشور',   'en'    =>  'Delete Post'], 'route' => 'posts/{posts}', 'module' => 'posts', 'as' => 'posts.destroy', 'icon' => null, 'parent' => $managePosts->id, 'parent_original' => $managePosts->id, 'parent_show' => $managePosts->id, 'sidebar_link' => '0', 'appear' => '0']);


        // About Instatutes
        $manageAboutInstatutes = Permission::create(['name' => 'manage_about_instatutes', 'display_name' => ['ar'  =>  'عن المعهد',    'en'    =>  'About Instatutes'], 'route' => 'about_instatutes', 'module' => 'about_instatutes', 'as' => 'about_instatutes.index', 'icon' => 'fas fas fa-newspaper', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '75',]);
        $manageAboutInstatutes->parent_show = $manageAboutInstatutes->id;
        $manageAboutInstatutes->save();
        $showAboutInstatutes   =  Permission::create(['name'  => 'show_about_instatutes', 'display_name'       =>  ['ar'   =>  'عن المعهد',   'en'    =>  'About Instatutes'], 'route' => 'about_instatutes', 'module' => 'about_instatutes', 'as' => 'about_instatutes.index', 'icon' => 'fas fas fa-newspaper', 'parent' => $manageAboutInstatutes->id, 'parent_original' => $manageAboutInstatutes->id, 'parent_show' => $manageAboutInstatutes->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createAboutInstatutes =  Permission::create(['name'  => 'create_about_instatutes', 'display_name'     =>  ['ar'   =>  'إنشاء بيانات عن المعهد',   'en'    =>  'Create About Instatute Info'], 'route' => 'about_instatutes', 'module' => 'about_instatutes', 'as' => 'about_instatutes.create', 'icon' => null, 'parent' => $manageAboutInstatutes->id, 'parent_original' => $manageAboutInstatutes->id, 'parent_show' => $manageAboutInstatutes->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayAboutInstatutes =  Permission::create(['name' => 'display_about_instatutes', 'display_name'    =>  ['ar'   =>  'عرض بيانات المعهد',   'en'    =>  'Display About Instatute Info'], 'route' => 'about_instatutes', 'module' => 'about_instatutes', 'as' => 'about_instatutes.show', 'icon' => null, 'parent' => $manageAboutInstatutes->id, 'parent_original' => $manageAboutInstatutes->id, 'parent_show' => $manageAboutInstatutes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateAboutInstatutes  =  Permission::create(['name' => 'update_about_instatutes', 'display_name'     =>  ['ar'   =>  'تعديل بيانات المعهد',   'en'    =>  'Edit About Instatute Info'], 'route' => 'about_instatutes', 'module' => 'about_instatutes', 'as' => 'about_instatutes.edit', 'icon' => null, 'parent' => $manageAboutInstatutes->id, 'parent_original' => $manageAboutInstatutes->id, 'parent_show' => $manageAboutInstatutes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteAboutInstatutes =  Permission::create(['name'  => 'delete_about_instatutes', 'display_name'     =>  ['ar'   =>  'حذف بيانات المعهد',   'en'    =>  'Delete About Instatute Info'], 'route' => 'about_instatutes', 'module' => 'about_instatutes', 'as' => 'about_instatutes.destroy', 'icon' => null, 'parent' => $manageAboutInstatutes->id, 'parent_original' => $manageAboutInstatutes->id, 'parent_show' => $manageAboutInstatutes->id, 'sidebar_link' => '0', 'appear' => '0']);


        //Tags
        $manageTags = Permission::create(['name' => 'manage_tags', 'display_name' => ['ar'  =>  'إدارة الكلمات المفتاحية',  'en'    =>  'Manage Tags'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.index', 'icon' => 'fas fa-tags', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '130',]);
        $manageTags->parent_show = $manageTags->id;
        $manageTags->save();
        $showTags    =  Permission::create(['name' => 'show_tags',  'display_name' =>   ['ar'   =>  ' الكلمات المفتاحية',   'en'        =>  'Tags'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.index', 'icon' => 'fas fa-tags', 'parent' => $manageTags->id, 'parent_original' => $manageTags->id, 'parent_show' => $manageTags->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createTags  =  Permission::create(['name' => 'create_tags', 'display_name'  =>   ['ar'   =>  'إضافة كلمة مفتاحية',   'en'       =>  'Add New Tag'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.create', 'icon' => null, 'parent' => $manageTags->id, 'parent_original' => $manageTags->id, 'parent_show' => $manageTags->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayTags =  Permission::create(['name' => 'display_tags', 'display_name'  =>   ['ar'   =>  'استعراض كلمة مفتاحية',   'en'      =>  'Display Tag'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.show', 'icon' => null, 'parent' => $manageTags->id, 'parent_original' => $manageTags->id, 'parent_show' => $manageTags->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateTags  =  Permission::create(['name' => 'update_tags', 'display_name'  =>   ['ar'   =>  'تعديل كلمة مفتاحية',   'en'        =>  'Update Tag'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.edit', 'icon' => null, 'parent' => $manageTags->id, 'parent_original' => $manageTags->id, 'parent_show' => $manageTags->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteTags  =  Permission::create(['name' => 'delete_tags', 'display_name'  =>   ['ar'   =>  'حذف لكمة مفتاحية',   'en'          =>  'Delete Tag'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.destroy', 'icon' => null, 'parent' => $manageTags->id, 'parent_original' => $manageTags->id, 'parent_show' => $manageTags->id, 'sidebar_link' => '0', 'appear' => '0']);


        //Site Settings Holder 
        $manageSiteSettings = Permission::create(['name' => 'manage_site_settings', 'display_name' => ['ar' =>  'الاعدادات العامة', 'en'    =>  'General Settings'], 'route' => 'settings', 'module' => 'settings', 'as' => 'settings.index', 'icon' => 'fa fa-cog', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '180',]);
        $manageSiteSettings->parent_show = $manageSiteSettings->id;
        $manageSiteSettings->save();

        // Site Infos 
        $displaySiteInfos =  Permission::create(['name' => 'display_site_infos', 'display_name'     => ['ar'   =>  'إدارة  بيانات الموقع', 'en'  =>  'Manage Site Infos'], 'route' => 'settings.site_main_infos', 'module' => 'settings.site_main_infos', 'as' => 'settings.site_main_infos.show', 'icon' => 'fa fa-info-circle', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteInfos  =  Permission::create(['name' => 'update_site_infos', 'display_name'      => ['ar'    =>  'تعديل بيانات الموقع', 'en'    =>  'Edit Site Infos'], 'route' => 'settings.site_main_infos', 'module' => 'settings.site_main_infos', 'as' => 'settings.site_main_infos.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site Contacts  
        $displaySiteContacts =  Permission::create(['name' => 'display_site_contacts', 'display_name'   => ['ar'    =>  'إدارة  بيانات الإتصال ', 'en' =>  'Manage Site Contact '], 'route' => 'settings.site_contacts', 'module' => 'settings.site_contacts', 'as' => 'settings.site_contacts.show', 'icon' => 'fa fa-address-book', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteContacts  =  Permission::create(['name' => 'update_site_contacts', 'display_name'    => ['ar'    =>  'تعديل بيانات الإتصال ', 'en'   =>  'Edit Site Contact '], 'route' => 'settings.site_contacts', 'module' => 'settings.site_contacts', 'as' => 'settings.site_contacts.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site Socials
        $displaySiteSocails =  Permission::create(['name' => 'display_site_socials', 'display_name'     =>  ['ar'   =>  ' إدارة  حسابات التواصل  ',   'en'    =>  'Manage Site Socials'], 'route' => 'settings.site_socials', 'module' => 'settings.site_socials', 'as' => 'settings.site_socials.show', 'icon' => 'fas fa-rss', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteSocails  =  Permission::create(['name' => 'update_site_socials', 'display_name'      =>  ['ar'   =>  'تعديل حسابات التواصل ',   'en'    =>  'Edit Site Contact Infos'], 'route' => 'settings.site_socials', 'module' => 'settings.site_socials', 'as' => 'settings.site_socials.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site SEO
        $displaySiteMetas =  Permission::create(['name' => 'display_site_meta', 'display_name'     =>  ['ar'   =>  'إدارة  SEO',   'en'    =>  'Manage Site SEO'], 'route' => 'settings.site_meta', 'module' => 'settings.site_meta', 'as' => 'settings.site_meta.show', 'icon' => 'fa fa-tag', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteMetas  =  Permission::create(['name' => 'update_site_meta', 'display_name'      =>  ['ar'   =>  'تعديل SEO',   'en'    =>  'Edit Site SEO'], 'route' => 'settings.site_meta', 'module' => 'settings.site_meta', 'as' => 'settings.site_meta.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);
    }
}
