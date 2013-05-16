# Makefile for the uska.de website
#
# $Id$

SCRIPTLET_PACKAGE=de.uska.scriptlet
TARGET_HOST=u34002701@uska.de
TARGET_PATH=$(TARGET_HOST):~/uska-xp/

PROJECT_NAME=uska
PROJECT_VERSION?=2.2.0-SNAPSHOT

dbclasses:
	@xpcli net.xp_framework.db.generator.DataSetCreator -c conf/db/uska/config.ini
	@for i in `find conf/db/uska/tables/ -name '*.xml' -type f`; do \
      xpcli net.xp_framework.db.generator.DataSetCreator -c conf/db/uska/config.ini -X $$i -O classes ; \
    done

install.stage: target/uska-$(PROJECT_VERSION).zip
	scp target/uska-$(PROJECT_VERSION).zip $(TARGET_PATH)
	@echo "mkdir uska-xp/uska-$(PROJECT_VERSION); cd uska-xp/uska-$(PROJECT_VERSION) && rm -rf * && unzip -q ../uska-$(PROJECT_VERSION).zip && ln -s ../lib/bootstrap/tools/web.php doc_root/" | ssh $(TARGET_HOST)
	@echo "cd uska-xp && rm uska-stage && ln -s uska-$(PROJECT_VERSION) uska-stage" | ssh $(TARGET_HOST)

install.real: target/uska-$(PROJECT_VERSION).zip
	@scp target/uska-$(PROJECT_VERSION).zip $(TARGET_PATH)
	@echo "mkdir uska-xp/uska-$(PROJECT_VERSION); cd uska-xp/uska-$(PROJECT_VERSION) && unzip ../uska-$(PROJECT_VERSION).zip" | ssh $(TARGET_HOST)
	@echo "cd uska-xp && cp uska-current/etc/database.ini $(PROJECT_NAME)-$(PROJECT_VERSION)/etc/" | ssh u34002701@uska.de

activate:
	@echo "cd uska-xp && ln -sf $(PROJECT_NAME)-$(PROJECT_VERSION) uska-current" | ssh u34002701@uska.de
