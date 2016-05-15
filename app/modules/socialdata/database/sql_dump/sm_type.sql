
--
-- Database: `osp_social`
--

-- --------------------------------------------------------

--
-- Table structure for table `sm_type`
--

CREATE TABLE IF NOT EXISTS `sm_type` (
  `id` int(10) unsigned NOT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `access_token` text COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive','cancel') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sm_type`
--

INSERT INTO `sm_type` (`id`, `type`, `access_token`, `code`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'google_plus', '{"access_token":"ya29.nQKjudMdXupDgXmc3kjPIXp-M_kGV8G5FUMsJUtezKnuca0EmVS1lWPyZnWMuvrvQA","token_type":"Bearer","expires_in":3600,"id_token":"eyJhbGciOiJSUzI1NiIsImtpZCI6ImQyYjE4MGRmMWNkMmVlYzExMzhiNTNlM2E3ODBiNTNlMmNhYTlhZmQifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXRfaGFzaCI6IkJvajhEbWRWOVNMUC1TTDdxcjRUUXciLCJhdWQiOiI5NzQ3OTEyNzQzMzktZG9jdDMzM2hqa2RvYjZtY2NxdXZ1bzIxazY2MnM3bTUuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMTE3ODYwNzI5NjM1Mzg0NjM3NTgiLCJhenAiOiI5NzQ3OTEyNzQzMzktZG9jdDMzM2hqa2RvYjZtY2NxdXZ1bzIxazY2MnM3bTUuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJpYXQiOjE0NTcyNTE3MzQsImV4cCI6MTQ1NzI1NTMzNH0.hCyfjADjxO-M8JONVLBgyRFzbDYjngItzZFFYUD7HG6WZR40mG6KT573OpHDfcu87powKZ4rVYAy0CpgRIu0YKSWh6fllC-IEECWGO16Rphg9FbQnCNfXR4Wz9NmBzdBnyFb6hp-V8zC0lims7Ss0rsnua1jwL7NPdyD1tL-s6MWbk4u9TKVKUtytVkWks5nZkhUift523Jcjz6q2UzJW8XIXQ0ysRtum4Jlf65Z7heBStVa0ICrTShglmOjcs4TcEGBQIQVJpmfBxoJ4Pt6N_kAe3nO39MmJQ-28l6Ndg_VYgwdWdETTrxhsTuawtisUC5nPw1frbeSmadIKpXkYA","refresh_token":"1\\/5dbqYrUbXSRJkr5Tv155HGauDR68pKxiLH8vl3JUb7590RDknAdJa_sgfheVM0XT","created":1457251735}', '4/ohTdxbZ-Q8FLrfl0VJUwVxelLcm3cQNW_8DeyAMh3Ho', 'active', 0, 0, '2016-03-06 02:03:59', '2016-03-06 02:08:55'),
(2, 'facebook', '', '', 'active', 0, 0, '2016-03-08 11:04:05', '2016-03-08 11:04:05'),
(3, 'twitter', '', '', 'active', 0, 0, '2016-03-09 12:59:12', '2016-03-14 14:33:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sm_type`
--
ALTER TABLE `sm_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sm_type_type_unique` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sm_type`
--
ALTER TABLE `sm_type`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;