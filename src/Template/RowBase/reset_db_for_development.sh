#!bin/cake migrations
# 最初までロールバック
bin/cake migrations rollback -t 0
bin/cake migrations migrate
bin/cake migrations seed -s Seeds/production
bin/cake migrations seed -s Seeds/development
