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
  |	http://codeigniter.com/user_guide/general/routing.html
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
$route['translate_uri_dashes'] = FALSE;
$route['home'] = 'welcome';

//User routes
$route['login'] = 'user/login';
$route['logout'] = 'user/logout';
$route['signin'] = 'user/signin';
$route['signup'] = 'user/signup';
$route['patient/medical'] = 'user/history';
$route['medical/history'] = 'user/history';
$route['patient/pastappointments'] = 'user/appointment_dash';
$route['user/profile'] = 'user/profile_settings';
$route['update-profile'] = 'user/update_profile';
$route['update-profesional'] = 'user/update_profesional';
$route['update-photo'] = 'user/do_upload';
$route['settings/account'] = 'user/account_settings';
$route['settings/mobile'] = 'user/mobile_settings';
$route['log-in'] = 'user/log__in';
$route['create-account'] = 'user/create_account';
$route['join/start'] = 'user/join_practice';
$route['update-username'] = 'user/update_username';
$route['update-password'] = 'user/update_password';
$route['update-delete'] = 'user/update_delete';
$route['update-phone'] = 'user/update_phone';
$route['settings/social'] = 'user/social_settings';
$route['password/reset'] = 'user/reset_password';
$route['practice/join'] = 'user/practice_join';
$route['join/thanks'] = 'user/thanks';



$route['review'] = 'welcome/review';



//Admin routes
$route['admin/dashboard'] = 'admin';
$route['admin/specialist'] = 'admin/specialist';
$route['admin/patient'] = 'admin/patient';
$route['admin/appointment'] = 'admin/appointment';
$route['admin/user'] = 'admin/view_user';
$route['edit-user/(:any)'] = 'admin/crud_user/$1';
$route['admin/insurance'] = 'admin/insurance';
$route['save-insurance'] = 'admin/save_insurance';
$route['save-certification'] = 'admin/save_certification';
$route['admin/logs'] = 'admin/all_logs';
$route['admin/reports/(:any)'] = 'admin/reports/$1';
$route['admin/reports/f_appointment/(:any)'] = 'admin/filter_appointment/$1';
$route['user-verify'] = 'admin/verify_user';
$route['admin/reports/specific'] = 'admin/specific';
$route['admin/users'] = 'admin/users';
$route['u/user/(:any)'] = 'admin/view_user/$1';


//Specialist routes
$route['specialist/dashboard'] = 'specialist';
$route['specialist/schedule'] = 'specialist/timeslot';
$route['specialist/appointment'] = 'specialist/appointment';
$route['save-timeslot'] = 'specialist/save_timeslot';
$route['delete-timeslot'] = 'specialist/trush_timeslot';
$route['billing'] = 'specialist/billing';
$route['save-billing'] = 'specialist/save_billing';
$route['update-billing'] = 'specialist/update_billing';
$route['specialist/insurance'] = 'specialist/insurance';
$route['accept-insurance'] = 'specialist/accept_insurance';
$route['remove-insurance'] = 'specialist/remove_insurance';
$route['specialist/payments'] = 'specialist/payments';
$route['specialist/patients'] = 'specialist/patients';
$route['patient/detail/(:any)'] = 'specialist/patient_details/$1';
$route['specialist/reports/(:any)'] = 'specialist/reports/$1';
$route['specialist/reports/f_appointment/(:any)'] = 'specialist/filter_appointment/$1';
$route['specialist/reports/specific'] = 'specialist/specific';


//Search routes
$route['filtersearch'] = 'search/filter_search';
$route['provider/(:any)'] = 'search/provider/$1';
$route['filterprovider'] = 'search/filterprovider';


//Appointment
$route['startsignin'] = 'appointment/bookcheck';
$route['reserve'] = 'appointment/reserve';
$route['reserve-success'] = 'appointment/reserve_success';
$route['appointment/detail/(:any)'] = 'appointment/appointment_details/$1';
$route['reschedule'] = 'appointment/reschedule';
$route['confirm-appointment'] = 'appointment/confirm_appointment';
$route['clear-appointment'] = 'appointment/clear_appointment';
$route['cancel-appointment'] = 'appointment/cancel_appointment';
$route['pay/(:any)'] = 'pay/details/$1';



$route['send'] = 'welcome/send';


//Notifications
$route['clear_notif'] = 'notification/clear_notif';

//Reviews
$route['writeareview/(:any)'] = 'review/writeareview/$1';
$route['publish/review'] = 'review/write_review';


//Payment
$route['pay'] = 'pay/payment';
$route['pay/confirm'] = 'pay/confirm';
$route['prepay'] = 'pay/proccess_payment';
$route['payment/confirm'] = 'pay/process_confirmation';


//Tests
$route['tests/sample'] = 'tests/sample';


//Android routes
$route['a/createaccount'] = 'android/signup';
$route['a/login'] = 'android/login';