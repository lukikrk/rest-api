DE=docker exec -it -u www-data nord

application:
	make install --no-print-directory
	@$(DE) make 2>&1 > /dev/null

########################################################################################################################

analyse:
	$(DE) php ./vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --verbose
	$(DE) php ./vendor/bin/phpstan analyse
	$(DE) php ./vendor/bin/phpmd src,tests,public/index.php text phpmd.xml --color -vvv
	$(DE) php ./vendor/bin/deptrac
	$(DE) php ./vendor/bin/psalm --no-cache

bash:
	@$(DE) bash

cli-docs:
	@$(DE) php bin/console

down:
	docker compose down

fix:
	$(DE) php ./vendor/bin/php-cs-fixer fix --allow-risky=yes

install:
	[ -f .env ] || cp .env.dist .env
	docker compose up -d --build

logs:
	docker logs -f nord

root:
	@echo '🕷 With great power comes great responsibility! 🕷'
	@docker exec -u root -it nord bash

stop:
	docker compose stop

test:
	$(DE) bin/console c:c --env=test
	$(DE) bin/console c:w --env=test
	$(DE) bin/console d:d:d --force --env=test --if-exists
	$(DE) bin/console d:d:c --env=test --if-not-exists
	$(DE) bin/console d:s:u --force --env=test
	$(DE) ./bin/phpunit

up:
	docker compose up -d
	@$(DE) make 2>&1 > /dev/null

xoff:
	docker exec nord xoff

xon:
	docker exec nord xon
