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

migrate_up:
	docker compose exec -T php bash -c "php commands/migrate-up.php"

migrate_down:
	docker compose exec -T php bash -c "php commands/migrate-down.php"

down:
	docker compose down
