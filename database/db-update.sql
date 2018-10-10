ALTER TABLE `tbl_product_categories` ADD `prodcat_code` VARCHAR(255) NOT NULL AFTER `prodcat_deleted`;

ALTER TABLE `tbl_banner_locations` DROP `blocation_banner_width`, DROP `blocation_banner_height`;

CREATE TABLE `tbl_banner_location_dimensions` (
  `bldimension_blocation_id` int(11) NOT NULL,
  `bldimension_device_type` int(11) NOT NULL,
  `blocation_banner_width` decimal(10,0) NOT NULL,
  `blocation_banner_height` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_banner_location_dimensions` (`bldimension_blocation_id`, `bldimension_device_type`, `blocation_banner_width`, `blocation_banner_height`) VALUES
(1, 1, '960', '400'),
(1, 2, '1024', '360'),
(1, 3, '760', '360'),
(2, 1, '1920', '400'),
(2, 2, '1024', '360'),
(2, 3, '760', '360'),
(3, 1, '310', '460'),
(3, 2, '310', '460'),
(3, 3, '310', '460');