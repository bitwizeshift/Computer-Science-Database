include ./install/config.mk

all: build

build: 
	echo 'Creating settings.ini'
	@echo '[database]' > ./static/src/settings.ini
	@echo ' dsn = "mysql:host=$(DBHOST);dbname=$(DBNAME)"' >> ./static/src/settings.ini
	@echo ' usr = "$(DBUSER)"' >> ./static/src/settings.ini
	@echo ' pwd = "$(DBPASS)"' >> ./static/src/settings.ini
	echo 'Creating database'
	@mysql --user=$(DBUSER) --password=$(DBPASS) $(DBNAME) < ./create_tables.sql
	echo 'Setting up file permissions'
	@find . -type f -exec chmod 644 {} \; && find . -type d -exec chmod 755 {} \;
	
	
        
clean:
	echo 'Cleaning up install files...'
	-@rm -rf *.o 2>/dev/null || true
	-@rm -rf install 2>/dev/null || true
	-@rm Makefile 2>/dev/null || true
	@echo 'Cleanup complete.'