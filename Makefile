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

migrate_down_all:
	docker compose exec -T php bash -c "php commands/migrate-down.php 0"

migrate_status:
	docker compose exec -T php bash -c "php commands/migrate-status.php"

migrate_create:
	@if [ -z "$(desc)" ]; then \
		echo "Erro: Forneça uma descrição usando desc=\"Sua descrição\""; \
		echo "Exemplo: make migrate_create desc=\"Cria tabela de produtos\""; \
		exit 1; \
	fi
	docker compose exec -T php bash -c "php commands/create-migration.php \"$(desc)\""

down:
	docker compose down
