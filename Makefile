all:
	sudo docker build -t newhire-request .
	sudo docker run --rm --name newhire-request -d -p 80:80 newhire-request
build:
	sudo docker build -t newhire-request .
run:
	sudo docker run --rm --name newhire-request -d -p 80:80 newhire-request
stop:
	sudo docker stop newhire-request
restart:
	@make stop
	@make build
	@make run
rebuild:
	@make restart
console:
	sudo docker exec -it newhire-request bash