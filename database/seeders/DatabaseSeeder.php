<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //---------  insert basic user account  -----------
        $user = \App\Models\User::create([
            'name' => "admin",
            'user_name' => "admin",
            'user_type' => "admin",
            'password' => bcrypt(123456),
        ]);

        //---------  insert Settings of app  -----------

        \DB::table('settings')->insert([
            'ar_title' => "Kids area",
        ]);

        //---------  insert basic Permissions  -----------
        $statment = "INSERT INTO `permissions` (`id`, `parent_id`, `name`, `ar_name`, `type_order`, `type_name`, `ar_type_name`, `sub_type_name`, `ar_sub_type_name`, `level`, `class_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'settingIndex', ' قسم الإعدادت العامة', '1', NULL, NULL, NULL, NULL, 'parent', NULL, 'web', '2021-07-26 05:31:18', '2021-07-29 10:30:13'),
(2, 1, 'editGeneralSetting', 'البيانات العامة', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(3, 2, 'saveGeneralSettings', 'حفظ البيانات العامة', '2', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(9, 1, 'users index', ' المستخدمين', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(10, 9, 'usersAdding', 'اضافة مستخدم جديد', '1', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(11, 9, 'usersEditing', 'تعديل بيانات مستخدم', '2', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(12, 9, 'usersSingleDeleting', 'حذف مستخدم', '3', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(13, 9, 'usersMultiDeleting', 'حذف أكثر من مستخدم', '4', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(14, 9, 'usersIsBlocking', 'تفعيل\\عدم تفعيل المستخدم', '5', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(15, 1, 'lists index', 'القوائم', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(16, 15, 'listsAdding', 'اضافة قائمة جديد', '1', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(17, 15, 'listsEditing', 'تعديل بيانات قائمة', '2', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(18, 1, 'moreSettingPermission', 'صلاحيات اضافية', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(19, 18, 'logs Index', 'أنشطة المستخدمين', '1', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(21, 1, 'user permission index', 'صلاحيات المستخدمين', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(22, 21, 'userPermissionAdding', 'اضافة صلاحيات لمستخدم', '1', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(23, 21, 'userPermissionsEditing', 'تعديل صلاحيات مستخدم', '2', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(24, 21, 'userPermissionSingleDeleting', 'حذف صلاحيات مستخدم', '3', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(25, 21, 'userPermissionMultiDeleting', 'حذف صلاحيات أكثر من مستخدم', '4', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(26, NULL, 'ReservationManagement', 'قسم ادارة الحجز', '1', NULL, NULL, NULL, NULL, 'parent', NULL, 'web', '2021-07-26 05:31:18', '2021-07-29 10:30:13'),
(27, 26, 'ticketIndex', 'التذاكر', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(28, 27, 'ticketAdding', 'اضافة تذكرة', '1', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(29, 27, 'ticketEditing', 'تعديل تذكرة', '2', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(30, 27, 'ticketSingleDeleting', 'حذف تذكرة', '3', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(31, 27, 'ticketMultiDeleting', 'حذف أكثر من تذكرة', '4', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(32, 27, 'ticketShowHidden', 'تفعيل أو اخفاء التذكرة', '5', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(33, 26, 'addOnsIndex', 'الإضافات', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(34, 33, 'addOnsAdding', 'اضافة الإضافة', '1', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(35, 33, 'addOnsEditing', 'تعديل الإضافة', '2', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(36, 33, 'addOnsSingleDeleting', 'حذف الإضافة', '3', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(37, 33, 'addOnsMultiDeleting', 'حذف أكثر من إضافة', '4', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(38, 33, 'addOnsShowHidden', 'تفعيل أو اخفاء الإضافة', '5', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(39, 26, 'ordersIndex', 'الطلبات', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(40, 39, 'ordersAdding', 'اضافة الطلب', '1', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(41, 39, 'ordersEditing', 'تعديل الطلب', '2', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(42, 39, 'ordersSingleDeleting', 'حذف الطلب', '3', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(43, 39, 'ordersMultiDeleting', 'حذف أكثر من طلب', '4', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(44, NULL, 'cashier', 'الكاشير', '1', NULL, NULL, NULL, NULL, 'parent', NULL, 'web', '2021-07-26 05:31:18', '2021-07-29 10:30:13'),
(45, 26, 'clientsIndex', 'العملاء', '1', NULL, NULL, NULL, NULL, 'child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(46, 45, 'clientsAdding', 'اضافة عميل', '1', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(47, 45, 'clientsEditing', 'تعديل عميل', '2', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(48, 45, 'clientsSingleDeleting', 'حذف عميل', '3', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13'),
(49, 45, 'clientsMultiDeleting', 'حذف أكثر من عميل', '4', NULL, NULL, NULL, NULL, 'sub_child', NULL, 'web', '2021-01-25 05:55:37', '2021-07-29 10:30:13');
";
        \DB::statement($statment);


        //---------  Dynamic sliders  -----------

        $statment = "INSERT INTO `dynamic_sliders` (`id`, `en_title`, `ar_title`, `route_link`, `order_number`, `image`, `font_icon`, `permission_name`, `permission_id`, `parent_id`, `with_notification`, `is_shown`, `created_at`, `updated_at`) VALUES
(1, 'settings', 'الإعدادت', 'settingIndex.index', '0', 'dynamicSliders/162728739243974.png', 'fad fa-cogs', 'settingIndex', 1, NULL, 'no', 'shown', '2021-07-26 04:16:33', '2021-08-01 08:13:52'),
(2, 'general settings', 'الإعدادت العامة', 'generalSettings.index', '0', 'dynamicSliders/162728799395111.png', 'fad fa-sliders-v', 'editGeneralSetting', 2, 1, 'no', 'shown', '2021-07-26 04:26:33', '2021-07-26 04:26:33'),
(3, 'users', 'المستخدمين', 'users.index', '1', 'dynamicSliders/162728851946673.png', 'fad fa-user', 'users index', 9, 1, 'no', 'shown', '2021-07-26 04:35:19', '2021-08-08 09:00:24'),
(4, 'user permissions', 'صلاحيات المستخدمين', 'userPermissions.index', '2', 'dynamicSliders/162728974475214.png', 'fad fa-ballot-check', 'user permission index', 21, 1, 'no', 'shown', '2021-07-26 04:55:44', '2021-08-08 09:00:24'),
(5, 'lists controlling', 'التحكم فى القوائم', 'dynamicSliders.index', '4', 'dynamicSliders/162728990625512.png', 'fad fa-bars', 'lists index', 15, 1, 'no', 'shown', '2021-07-26 04:58:26', '2021-07-26 04:58:26'),
(6, 'user logs', 'أنشطة المستخدمين', 'logActivities.index', '3', 'dynamicSliders/162729011677742.png', 'fad fa-users', 'logs Index', 19, 1, 'no', 'shown', '2021-07-26 05:01:56', '2021-08-08 09:00:24'),
(7, 'Reservation management', 'إدارة الحجز', 'routingBasics.index', '1', 'dynamicSliders/162859306420595.png', 'fad fa-tasks', 'ReservationManagement', 26, NULL, 'no', 'shown', '2021-08-10 08:57:44', '2021-08-10 08:57:44'),
(8, 'clients', 'العملاء', 'customers.index', '0', 'dynamicSliders/162859324861124.png', 'fad fa-user', 'clientsIndex', 45, 7, 'no', 'shown', '2021-08-10 09:00:48', '2021-08-10 09:00:48'),
(9, 'tickets', 'التذاكر', 'tickets.index', '1', 'dynamicSliders/162859328426237.png', 'far fa-clipboard-check', 'ticketIndex', 27, 7, 'no', 'shown', '2021-08-10 09:01:24', '2021-08-10 09:01:24'),
(10, 'addOns', 'الإضافات', 'add-ons.index', '2', 'dynamicSliders/162859331677181.png', 'far fa-puzzle-piece', 'addOnsIndex', 33, 7, 'no', 'shown', '2021-08-10 09:01:56', '2021-08-10 09:01:56'),
(11, 'orders', 'الطلبات', 'orders.index', '3', 'dynamicSliders/162859336541476.png', 'fad fa-cart-arrow-down', 'ordersIndex', 39, 7, 'no', 'shown', '2021-08-10 09:02:45', '2021-08-10 09:02:45'),
(12, 'cashier', 'الكاشير', 'cashier.index', '2', 'dynamicSliders/162859340258326.png', 'fas fa-shopping-basket', 'cashier', 44, NULL, 'no', 'shown', '2021-08-10 09:03:22', '2021-08-10 09:03:22');
" ;
        \DB::statement($statment);

    }//end fun
}//end  class
