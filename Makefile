all: clean coverage

test:
	vendor/bin/phpunit

coverage:
	vendor/bin/phpunit --coverage-html=logs/build/coverage

view-coverage:
	open logs/build/coverage/index.html

clean:
	rm -rf logs/build/*

