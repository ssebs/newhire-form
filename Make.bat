@echo off

IF "%1%"=="" (
    REM no param set
    REM restart
    docker stop newhire-request
    docker build -t newhire-request .
    docker run -d -p 80:80 --rm --name newhire-request newhire-request
) ELSE IF "%1%"=="stop" (
    REM stop
    docker stop newhire-request
) ELSE IF "%1%"=="restart" (
    REM restart
    docker stop newhire-request
    docker build -t newhire-request .
    docker run -d -p 80:80 --rm --name newhire-request newhire-request
) ELSE IF "%1%"=="build" (
    REM  build
    docker build -t newhire-request .
) ELSE IF "%1%"=="start" (
    REM  build
    docker build -t newhire-request .
    docker run -d -p 80:80 --rm --name newhire-request newhire-request
)  ELSE IF "%1%"=="run" (
    REM restart
    docker build -t newhire-request .
    docker run -d -p 80:80 --rm --name newhire-request newhire-request
)  ELSE IF "%1%"=="console" (
    REM connect to console
    docker exec -it newhire-request bash
)