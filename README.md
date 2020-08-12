# woo-delete-users

MU Plugin for WooCommerce. Delete Users. Delete Orders. 

Adds buttons to WP Admin > WooCommerce > Tools > Status to delete users and orders

1. Delete up to 500 users except admins. Run multiple times to delete all. On multisites, deletes users for current blog, not network. 

2. Delete all customers without orders. If script times out, run again. On Multisites, deletes customers for current blog not for network.

3. Multisite Network: Delete all users not assigned to a blog. If script times out, run again.

4. Delete up to 500 orders. Run multiple times to delete all. On multisites, deletes users for current blog, not network. 

NOT FULLY TESTED. Used by myself as a quick way to clear users from a DB copied from live site over to development copy. Do not use on live site and always backup before using. 


***

If you need to delete a lot of users quickly, you can also do it directly in phpMyAdmin:

```php
DELETE from wp_users WHERE ID NOT IN (1,2);
DELETE from wp_usermeta WHERE user_id NOT IN (1,2);
```
(1,2) = full list of IDs you wish to keep  
wp_ = replace with your own DB prefix 
