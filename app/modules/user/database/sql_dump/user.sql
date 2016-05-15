
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `auth_key`, `access_token`, `csrf_token`, `ip_address`, `role_id`, `department_id`, `last_visit`, `expire_date`, `remember_token`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$FOVyaVndWN.PPC1Hk4lfF.kmLLOFP4rZZsgEBwAJoqAs8KCsOW2MS', NULL, NULL, '0Zh91UIAxOclPWNxrHk7d3v5xbbGNC', '127.0.1.1', 1, 1, '2016-03-03 04:08:28', '2020-06-04 10:47:37', 'K2Zeoufy52O0jCNDJz3hgCUBF9G47hwofkmHrqrpjVhk27xXiYNcE0CIV0Rs', 'active', 1, 1, '0000-00-00 00:00:00', '2016-03-03 10:16:28'),
(2, 'user', 'user@user.com', '$2y$10$9RGdZ5lu/pEyshuBzwMTjucC9u.n4EKnaq4Kwajta.tMlkRFLzptG', NULL, NULL, 'h7wuPsj1j8fYxWzaiJ6Y3RHlDHSLBt', '127.0.1.1', 2, 2, '2016-03-03 03:29:14', '2016-04-02 14:17:42', '7nDFH0uSQe5FSSJiuBsGFxilgeCHo0xVa1SH3VDp2f60ZieF3CBOL1vQ4NtP', 'active', 1, 2, '2016-03-03 08:18:05', '2016-03-03 10:08:23');

