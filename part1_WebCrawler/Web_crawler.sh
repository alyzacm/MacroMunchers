#!/bin/bash

echo Compiling Web_crawler...

javac -cp .:jsoup-1.8.1.jar Web_crawler.java Crawler_thread.java Thread_share.java Crawl.java RobotExclusionUtil.java

if [ -d $4 ]
	echo Removing $4...
	then rm -rf $4
fi 

echo Running Web_crawler...
java  -cp .:jsoup-1.8.1.jar Web_crawler $1 $2 $3 $4

echo Finished running Web_crawler. Check $4 for crawled pages. 