<?php


namespace DevWorkout\ScaffoldDocker\Scaffolders\Docker;


class AddSelenium extends AddService
{
    protected $question = 'Add selenium?';

    protected $name = 'selenium';

    public function service()
    {
        return <<<HERE
  selenium:
    build:
      context: \${DOCKER_DIR}/selenium
    ports:
      - "10104:4444"
      - "10204:5900"
    volumes:
      - /dev/shm:/dev/shm
      - \${APP_CODE_PATH_HOST}:\${APP_CODE_PATH_CONTAINER}
    networks:
      - backend
      - frontend
HERE;
    }

}