--
-- Dumping data for table `menu_panel`
--

INSERT INTO `menu_panel` (`id`, `menu_id`, `menu_type`, `menu_name`, `route`, `parent_menu_id`, `icon_code`, `menu_order`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, 'ROOT', 'ROOT', '#', 0, NULL, 0, 'active', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'MODU', 'Dashboard', 'dashboard', 1, 'fa fa-tachometer', 1, 'active', NULL, NULL, '2016-04-12 00:14:41', '2016-04-12 04:07:21'),
(3, 1, 'MODU', 'User', '#', 1, 'fa fa-user', 2, 'cancel', NULL, NULL, '2016-04-12 00:16:47', '2016-07-24 08:23:29'),
(4, 1, 'MENU', 'Permission Role', 'index-permission-role', 23, '111', 0, 'active', NULL, NULL, '2016-04-12 00:18:59', '2016-07-24 08:22:35'),
(6, 1, 'MENU', 'Profile', 'user-profile', 23, '11', 0, 'active', NULL, NULL, '2016-04-12 00:46:18', '2016-07-24 08:17:26'),
(7, 1, 'MENU', 'User List', 'user-list', 23, '11', 0, 'cancel', NULL, NULL, '2016-04-12 00:47:03', '2016-07-26 08:56:30'),
(8, 1, 'MENU', 'Role User', 'index-role-user', 23, '11', 0, 'active', NULL, NULL, '2016-04-12 00:47:53', '2016-07-24 08:23:00'),
(9, 1, 'MENU', 'User Activity', 'user-activity', 23, '11', 0, 'active', NULL, NULL, '2016-04-12 00:48:48', '2016-07-24 08:23:11'),
(10, 1, 'MODU', 'Social Data', '#', 1, 'fa fa-dashboard', 3, 'cancel', NULL, NULL, '2016-07-20 08:39:56', '2016-07-24 07:16:43'),
(11, 1, 'MENU', 'Post', 'index-post', 11, '#', 1, 'cancel', NULL, NULL, '2016-07-20 08:40:21', '2016-07-24 07:16:48'),
(12, 1, 'MENU', 'System Social Media', 'index-sm-type', 11, '#', 2, 'cancel', NULL, NULL, '2016-07-21 03:16:38', '2016-07-24 07:16:53'),
(13, 1, 'MODU', 'Social Media', '#', 1, 'fa fa-flash', 4, 'active', NULL, NULL, '2016-07-21 04:24:09', '2016-07-24 06:06:43'),
(14, 1, 'MENU', 'Make a Post', 'www/posts', 14, '#', 1, 'active', NULL, NULL, '2016-07-21 04:26:12', '2016-07-24 06:05:38'),
(15, 1, 'MENU', 'Authentication', 'google-api-view', 11, '#', 3, 'cancel', NULL, NULL, '2016-07-21 06:50:07', '2016-07-24 07:16:56'),
(16, 1, 'MENU', 'Social Media Status', 'www/add-social-media', 23, '#', 2, 'active', NULL, NULL, '2016-07-21 06:56:43', '2016-07-24 06:15:00'),
(17, 1, 'MENU', 'Company', 'index-company', 23, '#', 1, 'active', NULL, NULL, '2016-07-21 07:34:09', '2016-07-24 07:13:31'),
(18, 1, 'MODU', 'Settings', '#', 1, 'fa fa-gear', 10, 'active', NULL, NULL, '2016-07-24 06:14:35', '2016-07-24 06:14:35'),
(19, 1, 'MENU', 'Add Social Media', 'index-company-social-account', 14, '#', 2, 'active', NULL, NULL, '2016-07-24 06:55:19', '2016-07-24 07:04:58'),
(20, 1, 'MENU', 'Manage Users', 'user-list', 23, '#', 3, 'active', NULL, NULL, '2016-07-24 07:49:00', '2016-08-02 17:01:28');