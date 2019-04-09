<?php

namespace DevWorkout\ScaffoldDocker\Scaffolders\Docker;


class AddWorkspace extends AddService
{
    protected $question = 'Add Workspace?';

    protected $name = 'workspace';

    public function service()
    {
        return <<<HERE
  workspace:
    build:
      context: \${DOCKER_DIR}/workspace
    volumes:
    - \${APP_CODE_PATH_HOST}:\${APP_CODE_PATH_CONTAINER}
    extra_hosts:
    - "dockerhost:\${DOCKER_HOST_IP}"
    tty: true
    networks:
    - frontend
    - backend
HERE;
    }

}