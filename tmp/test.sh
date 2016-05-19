curl -v \
-X POST \
-d "coreid=12345" \
-d "data=lat,lon,batt,name" \
http://makermap.us-west-1.elasticbeanstalk.com/tracker.update