# bbPress Reply by Email - Mandrill Handler

Send bbPress replies via Mandrill inbound mail. This is an add-on for [bbPress Subscription](https://github.com/rmccue/bbPress-Reply-by-Email) plugin by [Ryan McCue](https://github.com/rmccue)

Usage
------------------

1. Firstly install bbPress [bbPress Subscriptions](https://github.com/rmccue/bbPress-Reply-by-Email) plugin
2. Install this plugin.
3. Set `Mandrill` as `Messaging Handler` in plugin option
4. Set your `Reply-to Address`. e.g. `reply+%1$d-%2$s@yourdomain.com`
5. Based on the *Reply-to* address, set your **Route** in [Mandrill App inbound dashboard](https://mandrillapp.com/inbound).
6. Using this example address here, the route would be `reply+*@inbound.yourdomain.com*` *(set your domain mx record first)*
7. Set the webhook to `http://example.com/wp-admin/admin-post.php?action=bbsub`
8. You are set to go!


Author
----------------------------
[Tareq Hasan](http://tareq.wedevs.com)