ALTER TABLE `tbl_users` ADD `user_deleted` TINYINT(0) NOT NULL AFTER `user_order_tracking_url`;
--
-- Table structure for table `tbl_upc_codes`
--

CREATE TABLE `tbl_upc_codes` (
  `upc_code_id` bigint(15) NOT NULL,
  `upc_code` varchar(255) NOT NULL,
  `upc_product_id` bigint(15) NOT NULL,
  `upc_options` text NOT NULL,
  `upc_msrp` decimal(10,2) NOT NULL COMMENT 'selling price option specific'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_upc_codes`
--
ALTER TABLE `tbl_upc_codes`
  ADD PRIMARY KEY (`upc_code_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_upc_codes`
--
ALTER TABLE `tbl_upc_codes`
  MODIFY `upc_code_id` bigint(15) NOT NULL AUTO_INCREMENT;