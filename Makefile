# Makefile for the uska.de website
#
# $Id$ 

XPCLI_CMD?=xpcli

XP_VERSION=5.7.10
SCRIPTLET_PACKAGE=de.uska.scriptlet

include ../../Mk/common.mk
include ../../Mk/dist.mk
include ../../Mk/wrapper/generate.mk


dbclasses:
	@xpcli net.xp_framework.db.generator.DataSetCreator -c conf/db/uska/config.ini
	@for i in `find conf/db/uska/tables/ -name '*.xml' -type f`; do \
      xpcli net.xp_framework.db.generator.DataSetCreator -c conf/db/uska/config.ini -X $$i -O classes ; \
    done

install:
	@scp ../$(PROJECT_NAME)-$(PROJECT_VERSION).tar.gz u34002701@uska.de:~/uska-xp/
	@echo "cd uska-xp && tar xvzf $(PROJECT_NAME)-$(PROJECT_VERSION).tar.gz ; mv $(PROJECT_NAME) $(PROJECT_NAME)-$(PROJECT_VERSION)" | ssh u34002701@uska.de
	@echo "cd uska-xp && cp uska-current/etc/database.ini $(PROJECT_NAME)-$(PROJECT_VERSION)/etc/" | ssh u34002701@uska.de

activate:
	@echo "cd uska-xp && rm uska-current && ln -s $(PROJECT_NAME)-$(PROJECT_VERSION) uska-current" | ssh u34002701@uska.de
