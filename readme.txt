1. Made the favorites and wishlist manageable from admin.
2. Search filters with urls structure update.
3. Url rewriting update discarded slashes with url
4. Save search functionality
5. Implemented GDPR module.
6. Updated Cookie path CONF_WEBROOT_URL in case of setCookies.
7. tbl_user_favourite_products changed `ufp_product_id` to `ufp_selprod_id`
8. multiple options search filter listing update. 
9. Rewards point immediately get subtracted if order is on COD.
10. Enhancement in default image display in case of actual image not exist.

Note : Url rewriting update, discarded slashes with existing url. Need to change all / to - in tbl_url_rewrite  table urlrewrite_custom coloum. To do this you can hit the url domainname.com/dummy/change-custom-url. It will rewrite existing url structure and may impact on SEO.