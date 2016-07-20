--
-- Dumping data for table `menu_panel`
--

INSERT INTO `menu_panel` (`id`, `menu_id`, `menu_type`, `menu_name`, `route`, `parent_menu_id`, `icon_code`, `menu_order`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, 'ROOT', 'ROOT', '#', 0, NULL, 0, 'active', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'MODU', 'Dashboard', 'dashboard', 1, 'fa fa-tachometer', 1, 'active', NULL, NULL, '2016-04-12 06:14:41', '2016-04-12 10:07:21'),
(3, 1, 'MODU', 'User', '#', 1, 'fa fa-user', 3, 'active', NULL, NULL, '2016-04-12 06:16:47', '2016-04-12 10:07:46'),
(4, 1, 'MENU', 'Permission Role', 'index-permission-role', 3, '111', 0, 'active', NULL, NULL, '2016-04-12 06:18:59', '2016-04-12 06:44:49'),
-- (5, 1, 'MODU', 'Department', 'department', 1, 'fa fa-align-center', 2, 'active', NULL, NULL, '2016-04-12 06:42:21', '2016-04-12 10:07:34'),
(6, 1, 'MENU', 'Profile', 'user-profile', 3, '11', 0, 'active', NULL, NULL, '2016-04-12 06:46:18', '2016-04-12 06:46:18'),
(7, 1, 'MENU', 'User List', 'user-list', 3, '11', 0, 'active', NULL, NULL, '2016-04-12 06:47:03', '2016-04-12 06:47:03'),
(8, 1, 'MENU', 'Role User', 'index-role-user', 3, '11', 0, 'active', NULL, NULL, '2016-04-12 06:47:53', '2016-04-12 06:47:53'),
(9, 1, 'MENU', 'User Activity', 'user-activity', 3, '11', 0, 'active', NULL, NULL, '2016-04-12 06:48:48', '2016-04-12 06:48:48'),
(10, 1, 'MENU', 'Menu Panel', 'menu-panel', 3, '11', 0, 'active', NULL, NULL, '2016-04-12 06:49:29', '2016-04-12 06:49:29');