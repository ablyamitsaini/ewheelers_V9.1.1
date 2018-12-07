ALTER TABLE `tbl_languages` CHANGE `language_code` `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

CREATE TABLE `tbl_order_coupons_hold` (
  `ochold_order_id` varchar(15) NOT NULL,
  `ochold_coupon_id` int(11) NOT NULL,
  `ochold_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_order_coupons_hold`
--
ALTER TABLE `tbl_order_coupons_hold`
  ADD PRIMARY KEY (`ochold_order_id`,`ochold_coupon_id`);
