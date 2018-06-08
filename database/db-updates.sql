/* For recently added cronjobs for  items in cart and wishlist*/

 ALTER TABLE `tbl_user_cart` ADD `usercart_added_date` DATETIME NOT NULL AFTER `usercart_details`; 
 ALTER TABLE `tbl_user_cart` ADD `usercart_sent_reminder` INT NOT NULL AFTER `usercart_added_date`; 

 ALTER TABLE `tbl_user_wish_list_products` ADD `uwlp_sent_reminder` INT NOT NULL AFTER `uwlp_added_on`, ADD `uwlp_reminder_date` DATETIME NOT NULL AFTER `uwlp_sent_reminder`; 
  
 ALTER TABLE `tbl_user_cart` ADD `usercart_reminder_date` DATETIME NOT NULL AFTER `usercart_sent_reminder`; 


 INSERT INTO `tbl_cron_schedules` (`cron_id`, `cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES (9, 'Remind Buyer For Products In Cart', 'Cronjob/remindBuyerForProductsInCart', '1440', '1'); 
 INSERT INTO `tbl_cron_schedules` (`cron_id`, `cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES (10, 'Remind Buyer For Products In Wishlist', 'Cronjob/remindBuyerForProductsInWishlist', '1440', '1'); 


 INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('reminder_for_items_in_cart', '1', 'Reminder for items in Cart', 'Reminder for items in Cart', 'Reminder for items in Cart', '', '1'); 

 INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('reminder_for_items_in_wishlist', '1', 'Reminder for items in wishlist', 'Reminder for items in wishlist', 'Reminder for items in wishlist', '', '1'); 
  
 ALTER TABLE `tbl_users` DROP `user_app_access_token`;

 