# woo-delete-users
MU Plugin for WooCommerce. Delete Users. 

Adds buttons to WP Admin > WooCommerce > Tools > Status to delete users

1. Delete up to 500 users except admins. Run multiple times to delete all. On multisites, deletes users for current blog, not network. 

2. Delete all customers without orders. If script times out, run again. On Multisites, deletes customers for current blog not for network.

3. Multisite Network: Delete all users not assigned to a blog. If script times out, run again.

NOT FULLY TESTED. Used by myself as a quick way to clear users from a DB copied from live site over to development copy. Do not use on live site and always backup before using. 
