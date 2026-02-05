up:
	docker compose up -d

up_build:
	docker compose up -d --build

bash:
	docker compose exec php bash

db:
	docker compose exec mysql bash

composer_install:
	docker compose exec -T php bash -c "composer install"

migrate:
	docker compose exec -T mysql bash -c "mysql -u root -proot setup_lp < db.sql"

reset_db:
	docker compose down -v 'mysql' 
	$(MAKE) up
	sleep 15
	$(MAKE) migrate

down:
	docker compose down
