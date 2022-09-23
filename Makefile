build_unittest_image:
	docker rmi -f unittest_image && docker build -t unittest_image -f Dockerfile.test .

run_tests: build_unittest_image
	 docker run -it --rm --env-file=.env unittest_image ./vendor/bin/phpunit tests