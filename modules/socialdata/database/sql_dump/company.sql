
--
-- Database: `osp_social`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive','cancel') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `title`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'devdhaka405', 'active', 0, 0, '2016-03-06 02:04:00', '2016-03-06 02:04:00');
/*(2, 'bank of america', 'active', 0, 0, '2016-03-06 02:04:00', '2016-03-06 02:04:00'),
(3, 'United Nations', 'active', 0, 0, '2016-03-06 02:04:41', '2016-03-06 02:04:41'),
(4, 'Coca cola', 'active', 0, 0, '2016-03-14 10:27:26', '2016-03-14 10:27:26');*/

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;