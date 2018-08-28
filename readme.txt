1. Made the favorites and wishlist manageable from admin.
2. Search filters with urls structure update.
3. Url rewriting update discarded slashes with url
Note : Url rewriting update, discarded slashes with existing url. Need to change all / to - in tbl_url_rewrite  table urlrewrite_custom coloum. To do this you can hit the url domainname.com/dummy/change-custom-url. It will rewrite existing url structure and may impact on SEO.

4. Save search functionality
5. Implemented GDPR module.
6. Updated Cookie path CONF_WEBROOT_URL in case of setCookies.
7. tbl_user_favourite_products changed `ufp_product_id` to `ufp_selprod_id`
8. multiple options search filter listing update. 
9. Rewards point immediately get subtracted if order is on COD.
10. Enhancement in default image display in case of actual image not exist.
11. On Return request approval fixed seller amount credit issue.
12. Fixed Seller dashboard order sales status.
13. Fixed bugs related to GDPR module (#019780,#019784,#019783,#019781)
14. Fixed bugs - blur icon on blog page(#019782) and invalid access error on order status update (#019772).
15. DB updates to store order product setting based on configuration.
Note : hit the url http://domainname.com/dummy/update-order-prod-setting

