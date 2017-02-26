# Icinga2 to Slack Notification

#### Feel free to tweak these config files as required. In most cases it should work.

NOTE: _This setup steps assumes that `/etc/icinga2` is icinga2 config directory._

1. Set up a new incoming webhook for your team in slack.
2. Replace the value for SLACK_WEBHOOK_URL in `icinga2_slack_notification.php` by incoming webhook url you just created.
3. Add icinga2_slack_notification.php to /etc/icinga2/scripts directory.
4. Add contents of conf.d/users.conf to icinga users conf file (/etc/icinga2/conf.d/users.conf).
5. Add contents of conf.d/notifications.conf to icinga notifications conf file (/etc/icinga2/conf.d/notifications.conf).
6. Add contents of conf.d/commands.conf to icinga commands conf file (/etc/icinga2/conf.d/commands.conf).
7. And finally add slack variable to all host and services for which you want to enable slack notifications.
For example: Below code will enable slack notification for all http check for vhost. Because it defines `vars.notify = true`.
```
apply Service for (http_vhost => config in host.vars.http_vhosts) {
  import "generic-service"

  check_command = "http"

  vars += config
  vars.notify_slack=true
}
```

Similarly if you want to enable slack notifications for a host just add the variable `vars.notify_slack = true`.

That's it. You are good to go.
