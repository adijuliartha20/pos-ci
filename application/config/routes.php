<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;





/*START API*/
/*END API*/


/*START ADMIN*/

$route['locoadmin'] = 'dashboard';

$route['locoadmin/dashboard'] = 'dashboard';
$route['locoadmin/dashboard/get-monthly-sales'] = 'dashboard/get_monthly_sales';
$route['locoadmin/dashboard/get-yearly-sales'] = 'dashboard/get_yearly_sales';


$route['locoadmin/setting'] = 'setting';
$route['locoadmin/setting/save'] = 'setting/save';

$route['locoadmin/general-option'] = 'general_option';
$route['locoadmin/general-option/save'] = 'general_option/save';


/*start bonus*/
$route['locoadmin/bonus'] = 'bonus';
$route['locoadmin/bonus/create'] = 'bonus/create';
$route['locoadmin/bonus/edit/(:any)'] = 'bonus/create/$1';
$route['locoadmin/bonus/save'] = 'bonus/save';
$route['locoadmin/bonus/change-status'] = 'bonus/change_status';
$route['locoadmin/bonus/get-my-bonus'] = 'bonus/get_my_bonus';
$route['locoadmin/bonus/(:any)'] = 'bonus/index/$1';
$route['locoadmin/bonus/delete/(:any)'] = 'bonus/delete/$1';
/*end bonus*/


/*start check stok*/
$route['locoadmin/check-stock'] = 'check_stock';
$route['locoadmin/check-stock/save'] = 'check_stock/save';
$route['locoadmin/check-stock/get-item'] = 'check_stock/get_data_item';
/*end check stok*/

/*start buy items*/
$route['locoadmin/buy'] = 'buy';
$route['locoadmin/buy/save'] = 'buy/save';
$route['locoadmin/buy/get-item'] = 'buy/get_data_item';
/*end buy items*/


/*start transaction*/
$route['locoadmin/transaction'] = 'transaction';
$route['locoadmin/transaction/save'] = 'transaction/save';
$route['locoadmin/transaction/get-item'] = 'transaction/get_data_item';
$route['locoadmin/transaction/search-customer'] = 'transaction/search_customer';
/*end transaction*/

/*start report*/
$route['locoadmin/report'] = 'report';
$route['locoadmin/report/get-daily-report'] = 'report/get_daily_report';
$route['locoadmin/report/get-monthly-report'] = 'report/get_monthly_report';
$route['locoadmin/report/get-yearly-report'] = 'report/get_yearly_report';
$route['locoadmin/report/get-item-record'] = 'report/get_item_record';
$route['locoadmin/report/get-bestsellers-report'] = 'report/get_bestsellers_report';
$route['locoadmin/report/get-buy-items-report'] = 'report/get_buy_items_report';
$route['locoadmin/report/get-check-stock-report'] = 'report/get_check_stock_report';
$route['locoadmin/report/get-not-check-stock-report'] = 'report/get_not_check_stock_report';
$route['locoadmin/report/get-sales-not-paid-report'] = 'report/get_sales_not_paid';
$route['locoadmin/report/get-status-package-report'] = 'report/get_status_package_report';
$route['locoadmin/report/save-payment'] = 'report/save_payment';
$route['locoadmin/report/change-status-package'] = 'report/change_status_package';
$route['locoadmin/report/(:any)'] = 'report/index/$1';


$route['locoadmin/generate-report/daily/(:any)'] = 'generate_report/generate_daily_report/$1';
$route['locoadmin/generate-report/monthly/(:any)'] = 'generate_report/generate_monthly_report/$1';
$route['locoadmin/generate-report/yearly/(:any)'] = 'generate_report/generate_yearly_report/$1';
$route['locoadmin/generate-report/buy/(:any)'] = 'generate_report/buy_item/$1';
$route['locoadmin/generate-report/check-stock/(:any)'] = 'generate_report/check_stock/$1';
$route['locoadmin/generate-report/not-check-stock/(:any)'] = 'generate_report/not_check_stock/$1';
$route['locoadmin/generate-report/record-item/(:any)'] = 'generate_report/record_item/$1';
$route['locoadmin/generate-report/bestseller/(:any)'] = 'generate_report/bestseller/$1';
//$route['locoadmin/transaction'] = 'transaction';
/*end report*/


/*start events*/
$route['locoadmin/events'] = 'events';
$route['locoadmin/events/create'] = 'events/create';
$route['locoadmin/events/edit/(:any)'] = 'events/create/$1';
$route['locoadmin/events/save'] = 'events/save';
$route['locoadmin/events/change-status'] = 'events/change_status';
$route['locoadmin/events/(:any)'] = 'events/index/$1';
$route['locoadmin/events/delete/(:any)'] = 'events/delete/$1';
/*end events*/

/*start user*/
/*end user*/


/*start login*/
//$route['locoadmin/login/validate'] = 'login';
$route['locoadmin'] = 'auth';
$route['locoadmin/login'] = 'auth/login';
$route['locoadmin/logout'] = 'auth/logout';
/*end login*/

/*START BACKUP*/
$route['locoadmin/backup'] = 'backup';
/*END BACKUPEND*/



/*start consumen*/

$route['locoadmin/customer'] = 'customer';
$route['locoadmin/customer/create'] = 'customer/create';
$route['locoadmin/customer/edit/(:any)'] = 'customer/create/$1';
$route['locoadmin/customer/save'] = 'customer/save';
$route['locoadmin/customer/change-status'] = 'customer/change_status';
$route['locoadmin/customer/(:any)'] = 'customer/index/$1';
$route['locoadmin/customer/delete/(:any)'] = 'customer/delete/$1';


$route['locoadmin/sub-district'] = 'sub_district';
$route['locoadmin/sub-district/create'] = 'sub_district/create';
$route['locoadmin/sub-district/edit/(:any)'] = 'sub_district/create/$1';
$route['locoadmin/sub-district/save'] = 'sub_district/save';
$route['locoadmin/sub-district/change-status'] = 'sub_district/change_status';
$route['locoadmin/sub-district/delete/(:any)'] = 'sub_district/delete/$1';
$route['locoadmin/sub-district/get-sub-district'] = 'sub_district/get_list_sub_district';
$route['locoadmin/sub-district/(:any)'] = 'sub_district/index/$1';



$route['locoadmin/districts'] = 'districts';
$route['locoadmin/districts/create'] = 'districts/create';
$route['locoadmin/districts/edit/(:any)'] = 'districts/create/$1';
$route['locoadmin/districts/save'] = 'districts/save';
$route['locoadmin/districts/change-status'] = 'districts/change_status';
$route['locoadmin/districts/delete/(:any)'] = 'districts/delete/$1';
$route['locoadmin/districts/get-district'] = 'districts/get_list_district';
$route['locoadmin/districts/(:any)'] = 'districts/index/$1';


$route['locoadmin/province'] = 'province';
$route['locoadmin/province/create'] = 'province/create';
$route['locoadmin/province/edit/(:any)'] = 'province/create/$1';
$route['locoadmin/province/save'] = 'province/save';
$route['locoadmin/province/change-status'] = 'province/change_status';
$route['locoadmin/province/delete/(:any)'] = 'province/delete/$1';
$route['locoadmin/province/get-province'] = 'province/get_list_province';
$route['locoadmin/province/(:any)'] = 'province/index/$1';


$route['locoadmin/country'] = 'country';
$route['locoadmin/country/create'] = 'country/create';
$route['locoadmin/country/edit/(:any)'] = 'country/create/$1';
$route['locoadmin/country/save'] = 'country/save';
$route['locoadmin/country/change-status'] = 'country/change_status';
$route['locoadmin/country/(:any)'] = 'country/index/$1';
$route['locoadmin/country/delete/(:any)'] = 'country/delete/$1';
/*end consumen*/


/*start item*/
$route['locoadmin/items'] = 'items';
$route['locoadmin/items/create'] = 'items/create';
$route['locoadmin/items/edit/(:any)'] = 'items/create/$1';
$route['locoadmin/items/save'] = 'items/save';
$route['locoadmin/items/change-status'] = 'items/change_status';
$route['locoadmin/items/(:any)'] = 'items/index/$1';
$route['locoadmin/items/delete/(:any)'] = 'items/delete/$1';


$route['locoadmin/category-item'] = 'category_item';
$route['locoadmin/category-item/create'] = 'category_item/create';
$route['locoadmin/category-item/edit/(:any)'] = 'category_item/create/$1';
$route['locoadmin/category-item/save'] = 'category_item/save';
$route['locoadmin/category-item/change-status'] = 'category_item/change_status';
$route['locoadmin/category-item/(:any)'] = 'category_item/index/$1';
$route['locoadmin/category-item/delete/(:any)'] = 'category_item/delete/$1';


$route['locoadmin/store'] = 'store';
$route['locoadmin/store/create'] = 'store/create';
$route['locoadmin/store/edit/(:any)'] = 'store/create/$1';
$route['locoadmin/store/save'] = 'store/save';
$route['locoadmin/store/change-status'] = 'store/change_status';
$route['locoadmin/store/(:any)'] = 'store/index/$1';
$route['locoadmin/store/delete/(:any)'] = 'store/delete/$1';
/*end item*/


/*start user*/
$route['locoadmin/user/change-status'] = 'user/change_status';
$route['locoadmin/user/delete/(:any)'] = 'user/delete/$1';
$route['locoadmin/user/save'] = 'user/save';
$route['locoadmin/user/create'] = 'user/create';
$route['locoadmin/user/edit/(:any)'] = 'user/create/$1';
$route['locoadmin/edit-profile'] = 'user/edit_profile/';
$route['locoadmin/user/(:any)'] = 'user/index/$1';
$route['locoadmin/user'] = 'user';
/*end user*/
/*END ADMIN*/


/*START FRONTEND*/
$route['news/create'] = 'news/create';
$route['news/(:any)'] = 'news/view/$1';
$route['news'] = 'news';
/*END FRONTEND*/




//$route['(:any)'] = 'pages/view/$1';
//$route['default_controller'] = 'pages/view';