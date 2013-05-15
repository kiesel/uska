# Makefile for the uska.de website
#
# $Id$

SCRIPTLET_PACKAGE=de.uska.scriptlet
TARGET_HOST=u34002701@uska.de:~/uska-xp/

dbclasses:
	@xpcli net.xp_framework.db.generator.DataSetCreator -c conf/db/uska/config.ini
	@for i in `find conf/db/uska/tables/ -name '*.xml' -type f`; do \
      xpcli net.xp_framework.db.generator.DataSetCreator -c conf/db/uska/config.ini -X $$i -O classes ; \
    done

install.real:
	@scp target/uska-$(PROJECT_VERSION).zip $(TARGET_HOST)
	@echo "cd uska-xp && unzip uska-$(PROJECT_VERSION).tar.gz ; mv uska uska-$(PROJECT_VERSION)" | ssh u34002701@uska.de
	@echo "cd uska-xp && cp uska-current/etc/database.ini $(PROJECT_NAME)-$(PROJECT_VERSION)/etc/" | ssh u34002701@uska.de

activate:
	@echo "cd uska-xp && rm uska-current && ln -s $(PROJECT_NAME)-$(PROJECT_VERSION) uska-current" | ssh u34002701@uska.de
