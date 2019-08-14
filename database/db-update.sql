DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'MSG_customer_success_order';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'MSG_subscription_success_order';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'MSG_wallet_success_order';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'MSG_guest_success_order';

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('MSG_customer_success_order_{account}_{history}_{contactus}', '1', 'Your order has been successfully processed! You can view your order history by going to the {account} page and by clicking on {history}. Please direct any questions you have to the {contactus}. Thanks for shopping with us online!');

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('MSG_subscription_success_order_{account}_{subscription}', '1', 'Your subscription order has been successfully processed! You can view your order history by going to the {account} page and by clicking on {subscription}.');

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('MSG_wallet_success_order_{account}_{credits}', '1', 'Your wallet payment has been successfully processed! You can check your credits history by going to the {account} page and by clicking on {credits}.');

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('MSG_guest_success_order_{contactus}', '1', 'Your order has been successfully processed!Please direct any questions you have to the {contactus}. Thanks for shopping with us online!');
