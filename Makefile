# Makefile for the uska.de website
#
# $Id$ 

XPCLI_CMD?=xpcli

XP_VERSION=5.6.6
SCRIPTLET_PACKAGE=de.uska.scriptlet

include ../../Mk/common.mk
include ../../Mk/dist.mk
include ../../Mk/wrapper/generate.mk


dbclasses:
	@xpcli net.xp_framework.db.generator.DataSetCreator -c conf/db/uska/config.ini
	@for i in `find conf/db/uska/tables/ -name '*.xml' -type f`; do \
      xpcli net.xp_framework.db.generator.DataSetCreator -c conf/db/uska/config.ini -X $$i -O classes ; \
    done
