ALTER TABLE `tbl_orders_status` ADD `orderstatus_color_code` VARCHAR(10) NULL DEFAULT NULL AFTER `orderstatus_identifier`;

DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_THANK_YOU_FOR_REGISTERING';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_THANK_YOU_FOR_SIGNING_UP';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_THANKS_FOR_PLACING_AN_ORDER';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_YOUR_ORDER_PAYMENT_STATUS_CHANGED';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_AN_ORDER_HAS_BEEN_PLACED';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_YOUR_ORDER_ITEM_STATUS_CHANGED';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_YOUR_ACCOUNT_HAS_BEEN_TXN_TYPE_WITH_AMOUNT';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_YOUR_FUND_WITHDRAWAL_REQUEST_CHANGED';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_MESSAGE_RECEIVED_FROM_{USERNAME}';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_BUYER_HAS_SUBMITTED_ORDER_CANCELLATION_REQUEST';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_USERNAME_HAS_SUBMITTED_RETURN_REQUEST';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_YOUR_PRODUCT_RETURN_REQUEST_SUBMITTED';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_USERNAME_POSTED_MESSAGE_REQUEST_NUMBER';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_YOUR_ORDER_CANCELLATION_REQUEST_STATUS_CHANGED';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'M_APP_NOTIFICATION_YOUR_ACCOUNT_CREDITED_DEBITED_REWARD_POINTS';

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_VERIFY_YOUR_ACCCOUNT_FROM_REGISTERED_EMAIL', '1', 'Please verify your account from your registered emailLogo.');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_THANK_YOU_FOR_ACCOUNT_VERIFICATION', '1', 'Thank you for verifying your account.');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_YOUR_ORDER_{ORDERID}_HAVE_BEEN_PLACED', '1', 'Thank you for placing order {ORDERID}. Visit my order section for updates.');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_PAYMENT_STATUS_FOR_ORDER_{ORDERID}_UPDATED_{STATUS}', '1', 'Payment status for order {ORDERID} has been updated to {STATUS}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('SAPP_{PRODUCT}_ORDER_{ORDERID}_HAS_BEEN_PLACED', '1', 'You have received a new order {ORDERID} for {PRODUCT}.');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_YOUR_ORDER_{INVOICE}_{PRODUCT}_STATUS_{STATUS}', '1', 'Status for {PRODUCT} with invoice {INVOICE} has been updated to {STATUS}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_AMOUNT_{txn_amount}_WITH_{txn_id}_HAS_BEEN_{txn_type}', '1', 'Amount {txn_amount} with transaction id {txn_id} has been {txn_type} to your account');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_AMOUNT_{request_amount}_WITH_{request_id}_HAS_BEEN_{request_status}', '1', 'Withdrawal Amount {request_amount} with request id {request_id} has been {request_status}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_YOU_HAVE_A_NEW_MESSAGE_FROM_{USERNAME}', '1', 'You have a new message from {USERNAME}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('SAPP_RECEIVED_CANCELLATION_FOR_INVOICE_{invoice_number}', '1', 'Cancellation request received for invoice {invoice_number}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('SAPP_RECEIVED_RETURN_FROM_{username}_WITH_REFERENCE_NUMBER_{return_request_id}', '1', 'Return request receinved from {username} with reference number {return_request_id}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_RETURN_FOR_{return_prod_title}_with_{return_request_id}_submitted', '1', 'Return request for {prod} with reference number is successfully submitted.');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_NEW_MESSAGE_POASTED_BY_{username}_ON_RETURN_{request_number}', '1', 'New message posted by {username} on return request {return_request_id}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_STATUS_FOR_CANCELLATION_{invoice_number}_UPDATED_{request_status}', '1', 'Status for order cancellation invoice {invoice_number} has been updated to {request_status}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_REWARDS_{reward_points}_HAS_BEEN_{debit_credit_type}_ACCOUNT', '1', 'Reward points {reward_points} has been {debit_credit_type} to your account');

DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'MSG_customer_success_order';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'MSG_subscription_success_order';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'MSG_wallet_success_order';
DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'MSG_guest_success_order';

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('MSG_customer_success_order_{account}_{history}_{contactus}', '1', 'Your order has been successfully processed! You can view your order history by going to the {account} page and by clicking on {history}. Please direct any questions you have to the {contactus}. Thanks for shopping with us online!');

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('MSG_subscription_success_order_{account}_{subscription}', '1', 'Your subscription order has been successfully processed! You can view your order history by going to the {account} page and by clicking on {subscription}.');

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('MSG_wallet_success_order_{account}_{credits}', '1', 'Your wallet payment has been successfully processed! You can check your credits history by going to the {account} page and by clicking on {credits}.');

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('MSG_guest_success_order_{contactus}', '1', 'Your order has been successfully processed!Please direct any questions you have to the {contactus}. Thanks for shopping with us online!');

UPDATE
    `tbl_configurations`
SET
    `conf_val` = '<div class=\"construction-message\">\r\n	<h1>Site Under Maintenance</h1>\r\n	<svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"100.001px\" height=\"70px\" viewbox=\"0 0 100 68\">\r\n		<g id=\"large\">\r\n			<g transform=\"rotate(139.994 31 37)\">\r\n				<path d=\"M55.777,38.473l6.221-1.133c0.017-1.791-0.123-3.573-0.41-5.324l-6.321-0.19c-0.438-2.053-1.135-4.048-2.076-5.931 l4.82-4.094c-0.868-1.552-1.874-3.028-3.005-4.417l-5.569,2.999c-1.385-1.54-2.98-2.921-4.771-4.099l2.124-5.954 c-0.759-0.452-1.543-0.878-2.357-1.269c-0.811-0.39-1.625-0.732-2.449-1.046l-3.325,5.381c-2.038-0.665-4.113-1.052-6.183-1.174 L31.34,6.002c-1.792-0.02-3.571,0.119-5.32,0.406l-0.191,6.32c-2.056,0.439-4.051,1.137-5.936,2.08l-4.097-4.82 c-1.546,0.872-3.022,1.875-4.407,3.006l2.996,5.566c-1.54,1.384-2.925,2.985-4.104,4.778c-2.16-0.771-4.196-1.498-5.953-2.127 c-0.449,0.765-0.875,1.544-1.265,2.354c-0.39,0.811-0.733,1.63-1.049,2.457c1.587,0.981,3.424,2.119,5.377,3.325 c-0.662,2.037-1.049,4.117-1.172,6.186l-6.218,1.136c-0.021,1.789,0.12,3.566,0.407,5.321l6.32,0.188 c0.442,2.06,1.143,4.057,2.082,5.937l-4.818,4.095c0.872,1.549,1.873,3.026,3.009,4.412l5.563-2.998 c1.392,1.54,2.989,2.92,4.777,4.099l-2.121,5.954c0.756,0.446,1.538,0.871,2.348,1.258c0.813,0.394,1.633,0.739,2.462,1.05 l3.326-5.375c2.033,0.662,4.109,1.05,6.175,1.17l1.137,6.221c1.791,0.019,3.569-0.123,5.323-0.407l0.194-6.324 c2.053-0.438,4.045-1.136,5.927-2.079l4.093,4.817c1.55-0.865,3.026-1.87,4.414-2.999l-2.995-5.572 c1.537-1.385,2.914-2.98,4.093-4.772l5.953,2.127c0.448-0.761,0.878-1.545,1.268-2.356c0.388-0.808,0.729-1.631,1.047-2.458 l-5.378-3.324C55.268,42.615,55.655,40.542,55.777,38.473z M42.302,42.435c-3.002,6.243-10.495,8.872-16.737,5.866 c-6.244-2.999-8.872-10.493-5.867-16.736c3.002-6.244,10.495-8.873,16.736-5.869C42.676,28.698,45.306,36.19,42.302,42.435z\" fill=\"none\" stroke=\"#E43\"></path>    \r\n				<animatetransform attributename=\"transform\" begin=\"0s\" dur=\"3s\" type=\"rotate\" from=\"0 31 37\" to=\"360 31 37\" repeatcount=\"indefinite\" <=\"\" animatetransform=\"\"></animatetransform></g>\r\n			<g id=\"small\" transform=\"rotate(-209.992 78 21)\">\r\n				<path d=\"M93.068,19.253L99,16.31c-0.371-1.651-0.934-3.257-1.679-4.776l-6.472,1.404c-0.902-1.436-2.051-2.735-3.42-3.819 l2.115-6.273c-0.706-0.448-1.443-0.867-2.213-1.238c-0.774-0.371-1.559-0.685-2.351-0.958l-3.584,5.567 c-1.701-0.39-3.432-0.479-5.118-0.284L73.335,0c-1.652,0.367-3.256,0.931-4.776,1.672l1.404,6.47 c-1.439,0.899-2.744,2.047-3.835,3.419c-2.208-0.746-4.38-1.476-6.273-2.114c-0.451,0.71-0.874,1.448-1.244,2.229 c-0.371,0.764-0.68,1.541-0.954,2.329c1.681,1.078,3.612,2.323,5.569,3.579c-0.399,1.711-0.486,3.449-0.291,5.145 c-2.086,1.034-4.143,2.055-5.936,2.945c0.368,1.648,0.929,3.25,1.67,4.769c1.954-0.426,4.193-0.912,6.468-1.405 c0.906,1.449,2.06,2.758,3.442,3.853l-2.117,6.27c0.708,0.449,1.439,0.865,2.218,1.236c0.767,0.371,1.551,0.685,2.338,0.96 c1.081-1.68,2.319-3.612,3.583-5.574c1.714,0.401,3.457,0.484,5.156,0.288L82.695,42c1.651-0.371,3.252-0.931,4.773-1.676 c-0.425-1.952-0.912-4.194-1.404-6.473c1.439-0.902,2.744-2.057,3.835-3.436l6.273,2.11c0.444-0.7,0.856-1.43,1.225-2.197 c0.372-0.777,0.691-1.569,0.963-2.361l-5.568-3.586C93.181,22.677,93.269,20.939,93.068,19.253z M84.365,24.062 c-1.693,3.513-5.908,4.991-9.418,3.302c-3.513-1.689-4.99-5.906-3.301-9.419c1.688-3.513,5.906-4.991,9.417-3.302 C84.573,16.331,86.05,20.549,84.365,24.062z\" fill=\"none\" stroke=\"#E43\"></path>  \r\n  \r\n				<animatetransform attributename=\"transform\" begin=\"0s\" dur=\"2s\" type=\"rotate\" from=\"0 78 21\" to=\"-360 78 21\" repeatcount=\"indefinite\" <=\"\" animatetransform=\"\"></animatetransform></g></g></svg>\r\n	<h6>We are temporarily down for maintenance. Sorry for the inconvenience.<br />\r\n		To contact us in the meantime please email</h6><a href=\"mailto:email\" class=\"link\">login@dummyid.com</a>\r\n	<p class=\"pt-3\">or call 0111 111111</p></div>'
WHERE
    `tbl_configurations`.`conf_name` = 'CONF_MAINTENANCE_TEXT_1';

DELETE FROM `tbl_language_labels` WHERE `label_key` = "LBL_Tex_Charges";
DELETE FROM `tbl_language_labels` WHERE `label_key` LIKE 'MSG_Your_report_sent_review!';
ALTER TABLE `tbl_user_notifications` ADD `unotification_data` TEXT NULL DEFAULT NULL AFTER `unotification_type`;
/*Release notes TV-9.0.1.20190914*/
ALTER TABLE `tbl_attached_files` ADD `afile_updated_at` DATETIME NOT NULL AFTER `afile_downloaded_times`;
UPDATE `tbl_language_labels` SET `label_key` = 'APP_YOU_HAVE_A_NEW_MESSAGE_FROM_{username}' and `label_caption`= 'You have a new message from {username}' WHERE `tbl_language_labels`.`label_key` = 'APP_YOU_HAVE_A_NEW_MESSAGE_FROM_{USERNAME}';

DELETE FROM `tbl_language_labels` WHERE `label_key` LIKE 'MSG_Setup_successful';
DELETE FROM `tbl_language_labels` WHERE `label_key` LIKE 'MSG_File_deleted_successfully';
ALTER TABLE `tbl_language_labels` ADD `label_type` TINYINT(1) NOT NULL DEFAULT '1' AFTER `label_caption`;
ALTER TABLE `tbl_banners` ADD `banner_img_updated_on` DATETIME NOT NULL AFTER `banner_display_order`;
ALTER TABLE `tbl_slides` ADD `slide_img_updated_on` DATETIME NOT NULL AFTER `slide_display_order`;
DELETE FROM `tbl_language_labels` WHERE `label_key` LIKE '%LBL_Add_New_Special_Price%';

/*20-Sep-2019*/
UPDATE `tbl_language_labels` SET `label_key`= 'APP_AMOUNT_{txn-amount}_WITH_{txn-id}_HAS_BEEN_{txn-type}',`label_caption`= 'Amount {txn-amount} with transaction id {txn-id} has been {txn-type} to your account' WHERE `label_key` = 'APP_AMOUNT_{txn_amount}_WITH_{txn_id}_HAS_BEEN_{txn_type}';
UPDATE `tbl_language_labels` SET `label_key`= 'APP_AMOUNT_{request-amount}_WITH_{request-id}_HAS_BEEN_{request-status}',`label_caption`= 'Withdrawal Amount {request-amount} with request id {request-id} has been {request-status}' WHERE `label_key` = 'APP_AMOUNT_{request_amount}_WITH_{request_id}_HAS_BEEN_{request_status}';
UPDATE `tbl_language_labels` SET `label_key`= 'SAPP_RECEIVED_CANCELLATION_FOR_INVOICE_{invoice-number}',`label_caption`= 'Cancellation request received for invoice {invoice-number}' WHERE `label_key` = 'SAPP_RECEIVED_CANCELLATION_FOR_INVOICE_{invoice_number}';
UPDATE `tbl_language_labels` SET `label_key`= 'SAPP_RECEIVED_RETURN_FROM_{username}_WITH_REFERENCE_NUMBER_{return-request-id}',`label_caption`= 'Return request received from {username} with reference number {return-request-id}' WHERE `label_key` = 'SAPP_RECEIVED_RETURN_FROM_{username}_WITH_REFERENCE_NUMBER_{return_request_id}';
UPDATE `tbl_language_labels` SET `label_key`= 'APP_RETURN_FOR_{return-prod-title}_with_{return-request-id}_SUBMITTED',`label_caption`= 'Return request for {return-prod-title} with reference number {return-request-id} is successfully submitted.' WHERE `label_key` = 'APP_RETURN_FOR_{return_prod_title}_with_{return_request_id}_SUBMITTED';
UPDATE `tbl_language_labels` SET `label_key`= 'APP_NEW_MESSAGE_POSTED_BY_{username}_ON_RETURN_{request-number}',`label_caption`= 'New message posted by {username} on return request {request-number}' WHERE `label_key` = 'APP_NEW_MESSAGE_POASTED_BY_{username}_ON_RETURN_{request_number}';
UPDATE `tbl_language_labels` SET `label_key`= 'APP_STATUS_FOR_CANCELLATION_{invoice-number}_UPDATED_{request-status}',`label_caption`= 'Status for order cancellation invoice {invoice-number} has been updated to {request-status}' WHERE `label_key` = 'APP_STATUS_FOR_CANCELLATION_{invoice_number}_UPDATED_{request_status}';
UPDATE `tbl_language_labels` SET `label_key`= 'APP_REWARDS_{reward-points}_HAS_BEEN_{debit-credit-type}_ACCOUNT',`label_caption`= 'Reward points {reward-points} has been {debit-credit-type} to your account' WHERE `label_key` = 'APP_REWARDS_{reward_points}_HAS_BEEN_{debit_credit_type}_ACCOUNT';

DELETE FROM `tbl_language_labels` WHERE `label_key`= 'APP_AMOUNT_{txn-amount}_WITH_{txn-id}_HAS_BEEN_{txn-type}';
DELETE FROM `tbl_language_labels` WHERE `label_key`= 'APP_AMOUNT_{request-amount}_WITH_{request-id}_HAS_BEEN_{request-status}';
DELETE FROM `tbl_language_labels` WHERE `label_key`= 'SAPP_RECEIVED_CANCELLATION_FOR_INVOICE_{invoice-number}';
DELETE FROM `tbl_language_labels` WHERE `label_key`= 'SAPP_RECEIVED_RETURN_FROM_{username}_WITH_REFERENCE_NUMBER_{return-request-id}';
DELETE FROM `tbl_language_labels` WHERE `label_key`= 'APP_RETURN_FOR_{return-prod-title}_with_{return-request-id}_SUBMITTED';
DELETE FROM `tbl_language_labels` WHERE `label_key`= 'APP_NEW_MESSAGE_POSTED_BY_{username}_ON_RETURN_{request-number}';
DELETE FROM `tbl_language_labels` WHERE `label_key`= 'APP_STATUS_FOR_CANCELLATION_{invoice-number}_UPDATED_{request-status}';
DELETE FROM `tbl_language_labels` WHERE `label_key`= 'APP_REWARDS_{reward-points}_HAS_BEEN_{debit-credit-type}_ACCOUNT';

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_AMOUNT_{txnamount}_WITH_{txnid}_HAS_BEEN_{txntype}', 1,'Amount {txnamount} with transaction id {txnid} has been {txntype} to your account');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_AMOUNT_{requestamount}_WITH_{requestid}_HAS_BEEN_{requeststatus}', 1,'Withdrawal Amount {requestamount} with request id {requestid} has been {requeststatus}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('SAPP_RECEIVED_CANCELLATION_FOR_INVOICE_{invoicenumber}', 1,'Cancellation request received for invoice {invoicenumber}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('SAPP_RECEIVED_RETURN_FROM_{username}_WITH_REFERENCE_NUMBER_{returnrequestid}', 1,'Return request received from {username} with reference number {returnrequestid}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_RETURN_FOR_{returnprodtitle}_with_{returnrequestid}_SUBMITTED', 1,'Return request for {returnprodtitle} with reference number {returnrequestid} is successfully submitted.');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_NEW_MESSAGE_POSTED_BY_{username}_ON_RETURN_{requestnumber}', 1,'New message posted by {username} on return request {requestnumber}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_STATUS_FOR_CANCELLATION_{invoicenumber}_UPDATED_{requeststatus}', 1,'Status for order cancellation invoice {invoicenumber} has been updated to {requeststatus}');
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`) VALUES ('APP_REWARDS_{rewardpoints}_HAS_BEEN_{debitcredittype}_ACCOUNT', 1,'Reward points {rewardpoints} has been {debitcredittype} to your account');
