
--
-- Database: `osp_social`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_social_account`
--

CREATE TABLE IF NOT EXISTS `company_social_account` (
  `id` int(10) unsigned NOT NULL,
  `sm_account_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `sm_type_id` int(10) unsigned NOT NULL,
  `data_pull_duration` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive','cancel') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company_social_account`
--

INSERT INTO `company_social_account` (`id`, `sm_account_id`, `company_id`, `sm_type_id`, `data_pull_duration`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '111786072963538463758', 1, 1, 'all', 'active', 0, 0, '2016-03-06 02:04:00', '2016-03-06 02:04:00'),
(2, '+BankofAmerica', 2, 1, 'all', 'active', 0, 0, '2016-03-06 02:04:00', '2016-03-06 02:04:00'),
(3, '104158924758626757436', 3, 1, 'all', 'active', 0, 0, '2016-03-06 02:04:52', '2016-03-06 02:04:52'),
(4, 'unitednations', 3, 2, 'all', 'active', 0, 0, '2016-03-14 10:21:38', '2016-03-14 10:21:53'),
(5, 'BankofAmerica', 2, 2, 'all', 'active', 0, 0, '2016-03-14 10:22:26', '2016-03-14 10:22:26'),
(6, 'un', 3, 3, 'all', 'active', 0, 0, '2016-03-14 10:23:02', '2016-03-14 10:23:02'),
(7, 'bankofamerica', 2, 3, 'all', 'active', 0, 0, '2016-03-14 10:23:42', '2016-03-14 10:23:42'),
(8, 'coca-cola', 4, 2, 'all', 'active', 0, 0, '2016-03-14 10:27:37', '2016-03-14 10:27:37'),
(9, 'CocaCola', 4, 3, 'all', 'active', 0, 0, '2016-03-14 10:27:59', '2016-03-14 10:27:59'),
(10, '+Coca-Cola', 4, 1, 'all', 'active', 0, 0, '2016-03-14 10:29:24', '2016-03-14 10:29:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_social_account`
--
ALTER TABLE `company_social_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_social_account_company_id_sm_type_id_unique` (`company_id`,`sm_type_id`),
  ADD KEY `company_social_account_sm_type_id_foreign` (`sm_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_social_account`
--
ALTER TABLE `company_social_account`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `company_social_account`
--
ALTER TABLE `company_social_account`
  ADD CONSTRAINT `company_social_account_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `company_social_account_sm_type_id_foreign` FOREIGN KEY (`sm_type_id`) REFERENCES `sm_type` (`id`);

