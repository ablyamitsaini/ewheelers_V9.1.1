UPDATE `tbl_banner_locations` SET `blocation_key` = 'Home_Page_Top_Banner', `blocation_identifier` = 'Home page top banner', `blocation_banner_count` = '1' WHERE `tbl_banner_locations`.`blocation_id` = 1;
UPDATE `tbl_banner_locations` SET `blocation_key` = 'Home_Page_Bottom_Banner', `blocation_identifier` = 'home page bottom banner' WHERE `tbl_banner_locations`.`blocation_id` = 2;
TRUNCATE tbl_banner_location_dimensions;
INSERT INTO `tbl_banner_location_dimensions` (`bldimension_blocation_id`, `bldimension_device_type`, `blocation_banner_width`, `blocation_banner_height`) VALUES
(1, 1, '1200', '360'),
(1, 2, '1200', '360'),
(1, 3, '1200', '360'),
(2, 1, '1200', '360'),
(2, 2, '1200', '360'),
(2, 3, '1200', '360'),
(3, 1, '1200', '360'),
(3, 2, '1200', '360'),
(3, 3, '1200', '360');
UPDATE `tbl_theme_colors` SET `tcolor_header_text_color`= '323232';