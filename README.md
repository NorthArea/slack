# Simple Slack integration
1) Open required php file and fill in it
2) Connect to your server
3) load required file to the server
3) Open crontab -e
4) Add this string
```crontab
* * * * * php path_to_file/log.php
```