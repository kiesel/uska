# Makefile for the uska.de website
#
# $Id$ 

WRAPPER_PHP=../../../classes/de/uska/scriptlet/wrapper
PROJECT_DEPENDENCIES=xp-rt-5.6.2.xar

include ../../Mk/common.mk
include ../../Mk/dist.mk


dbclasses:
	for i in `ls -1 doc/dbxml/*.xml`; do \
		FILE=`basename $$i`; \
        CLASS=`echo $$FILE | sed -E 's/(.+)\.[a-z]+$$/\1/g'`; \
		sabcmd ../../databases/util/classgen/data/xp.php.xsl $$i > ../../../classes/de/uska/db/$$CLASS.class.php ; \
	done
