<?php


namespace DevWorkout\ScaffoldDocker\Scaffolders\Docker;


class AddPhp extends AddService
{
    protected $question = 'Add PHP?';

    protected $name = 'php-fpm';

    public function service()
    {
        return <<<HERE
  php-fpm:
    build:
      context: \${DOCKER_DIR}/php-fpm
    volumes:
    - \${APP_CODE_PATH_HOST}:\${APP_CODE_PATH_CONTAINER}
    - \${DOCKER_DIR}/php-fpm/php.ini:/usr/local/etc/php/php.ini
    expose:
    - "9000"
    depends_on:
    - workspace
    extra_hosts:
    - "dockerhost:\${DOCKER_HOST_IP}"
    networks:
    - backend
HERE;
    }

}