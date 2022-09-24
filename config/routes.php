// ===============VIEW STUDENT===============
$route['request/(:num)']['get'] = 'internview/request/$1';
$route['request/(:num)']['post'] = 'internview/request/$1';
$route['req-schedule']['post'] = 'internview/req_schedule';
$route['req-schedule']['get'] = 'internview/req_schedule';
$route['admin/requests/(:num)']['get'] = 'Adminview/requests_list/$1';
$route['admin/requests/(:num)']['post'] = 'Adminview/requests_list/$1';
$route['display-requests']['get'] = 'Adminview/display_requests';
$route['view-intr-request']['post'] = 'Adminview/view_intr_request';
$route['update-schedule-request']['post'] = 'Adminview/update_schedule_request';
$route['deny-schedule-request']['post'] = 'Adminview/deny_schedule_request';
$route['display-acpt-requests']['get'] = 'Adminview/display_acpt_requests';
$route['display-denied-requests']['get'] = 'Adminview/display_denied_requests';

// ===============STUDENT CONCERNS===============
$route['admin/concerns/(:num)']['get'] = 'Adminview/concerns_list/$1';
$route['admin/concerns/(:num)']['post'] = 'Adminview/concerns_list/$1';
$route['list-concerns']['get'] = 'Adminview/list_concerns';
$route['show-message/(:num)']['get'] = 'Adminview/show_message/$1';
$route['show-init-message/(:num)']['get'] = 'Adminview/show_init_message/$1';
$route['reply-to-concern']['post'] = 'Adminview/reply_to_concern'; 
$route['reply-concern-adm']['post'] = 'Adminview/reply_concern_adm';
$route['show-init-message/(:num)']['get'] = 'internview/show_init_message/$1';
$route['complete-concern-adm']['post'] = 'Adminview/complete_concern_adm';
$route['get-filter-date']['get'] = 'Adminview/get_filter_date';
$route['get-date-fil']['post'] = 'Adminview/get_date_fil';
$route['delete-concern']['post'] = 'Adminview/delete_concern'; 

// Concerns
$route['concern/(:num)']['get'] = 'internview/concern/$1';
$route['concern/(:num)']['post'] = 'internview/concern/$1';
$route['sub-concern']['post'] = 'internview/sub_concern';
$route['sub-concern']['get'] = 'internview/sub_concern';
$route['show-concerns/(:num)']['get'] = 'internview/show_concerns/$1';
$route['show-concerns/(:num)']['post'] = 'internview/show_concerns/$1';
$route['show-messages/(:num)']['get'] = 'internview/show_messages/$1';
$route['show-messages/(:num)']['post'] = 'internview/show_messages/$1';
$route['reply-concern']['post'] = 'internview/reply_concern';
