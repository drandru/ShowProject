SHELL=/bin/bash
.DEFAULT_GOAL := help
THIS_FILE := $(lastword $(MAKEFILE_LIST))
OS := `uname -s`
DOCKER_UID := `id -u`
DOCKER_GID := `id -g`

ifeq ($(OS), Darwin)
	DOCKER_UID := 1000
	DOCKER_GID := 1000
endif

.PHONY: help
help: ## Отобразить данное сообщение. Для дополнительной информации загляните в README.md
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: build
build: ## Собрать контейнер, как backend так и frontend (для backend) часть (запускает build)
	#@$(MAKE) build-backend-npm
	@$(MAKE) build-backend
	@$(MAKE) build-frontend
	@$(MAKE) build-db

.PHONY: build-backend
build-backend: ## Собрать контейнер app, подтянуть все зависимости, подготовить к запуску
	@if [[ ! -f './app/.env' ]]; then cp ./app/.env.example ./app/.env; fi
	@docker run --rm --interactive --tty \
		--volume ${PWD}/app:/app \
		-w /app \
		--user ${DOCKER_UID}:${DOCKER_GID} \
		--env-file ./app/.env \
		composer install --ignore-platform-reqs --no-scripts
	@docker compose pull app
	@docker compose build app

.PHONY: build-frontend
build-frontend: ## Собрать контейнер webserver, подтянуть все зависимости, подготовить к запуску
	@docker compose pull webserver
	@docker compose build webserver

.PHONY: build-backend-npm
build-backend-npm: ## Собрать npm файлы для app
	@docker pull node:20
	@docker run --rm -it \
		--volume ${PWD}/app:/app:rw \
		-w /app \
		node:20 bash -c "npm install && npm run dev"

.PHONY: build-db
build-db: ## Собрать контейнер database, подтянуть все зависимости, подготовить к запуску
	@docker compose pull postgresql-master

.PHONY: run-tests
run-tests: ## Запустить тесты
	@docker run \
		-w /app \
		--user root:root \
		kweek-admin-app bash -c "./vendor/bin/phpunit"


.PHONY: composer-update
composer-update: ## Обновить зависимости composer
	@docker run --rm --interactive --tty \
		--volume ${PWD}/app:/app \
		--volume ~/.ssh:/root/.ssh \
		--user ${DOCKER_UID}:${DOCKER_GID} \
		--env-file ./app/.env \
		$$(if [ -f "${HOME}/.config/composer/auth.json" ]; then echo "-v ${HOME}/.config/composer/auth.json:/tmp/auth.json" ; fi) \
		composer bash -c "composer update --ignore-platform-reqs --no-scripts"

.PHONY: start
start: ## Запускаем контейнеры в интерактивном режиме.
	@echo -e "\033[33mstart\033[0m"
	@docker compose -f docker-compose.yml up

.PHONY: start-d
start-d: ## Запускаем контейнеры в фоновом режиме.
	@echo -e "\033[33mstart\033[0m"
	@docker compose -f docker-compose.yml up -d


.PHONY: clean-all
clean-all: ## Удаление контейнера
	@echo -e "\033[33mclean\033[0m"
	@DOCKER_UID=${DOCKER_UID} DOCKER_GID=${DOCKER_GID} docker compose  rm -v
	@rm -f app/storage/init
	@rm -rf app/vendor
	@rm -rf app/storage/framework/cache/*
	@rm -rf app/storage/framework/sessions/*
	@rm -rf app/storage/framework/views/*

.PHONY: clean-deploy
clean-deploy: ## Удаление контейнера
	@echo -e "\033[33mclean\033[0m"
	@rm -f app/storage/init
	@rm -rf app/vendor
	@rm -rf app/storage/framework/cache/*
	@rm -rf app/storage/framework/sessions/*
	@rm -rf app/storage/framework/views/*



