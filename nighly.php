#!/bin/bash

GECKO_URL="git://github.com/mozilla/releases-mozilla-central"
GAIA_URL="git://github.com/mozilla-b2g/gaia"

#$1 gecko or gaia
#$2 remote server url
fetch_repositories() {
	cd $1
	git remote add nighly $2
	git fetch nighly
	git checkout -b nighly nighly/master
	cd ..
}

#$1 gecko or gaia
update_repositories() {
	cd $1
	if [ $1 = "gecko" ]; then
		git reset --hard
		git pull
		git apply *.patch
	else
		git pull
	fi
	cd ..
}

#$1 gecko or gaia
#$2 remote server url
check_repositories() {
	if [ -f ".$1url" ]; then
		update_repositories $1
	else
		fetch_repositories $1 $2
		touch .$1url
	fi
#	echo $1
}

check_repositories gecko $GECKO_URL
check_repositories gaia $GAIA_URL


#. build.sh
