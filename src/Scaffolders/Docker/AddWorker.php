<?php


namespace DevWorkout\ScaffoldDocker\Scaffolders\Docker;


class AddWorker extends AddService
{
    protected $question = 'Add queue worker?';

    protected $name = 'worker';

    public function service()
    {
        return <<<HERE
  worker:
    build:
      context: \${DOCKER_DIR}/worker
    volumes:
      - \${APP_CODE_PATH_HOST}:\${APP_CODE_PATH_CONTAINER}
    depends_on:
      - workspace
    extra_hosts:
      - "dockerhost:\${DOCKER_HOST_IP}"
    networks:
      - backend
HERE;
    }

}