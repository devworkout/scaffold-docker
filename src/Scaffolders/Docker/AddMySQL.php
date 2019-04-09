<?php


namespace DevWorkout\ScaffoldDocker\Scaffolders\Docker;


class AddMySQL extends AddService
{
    protected $question = 'Add MySQL?';

    protected $name = 'mysql';

    public function env()
    {
        return <<<HERE
MYSQL_DATABASE=homestead
MYSQL_USER=homestead
MYSQL_PASSWORD=secret
MYSQL_PORT=3307
MYSQL_ROOT_PASSWORD=root
MYSQL_ENTRYPOINT_INITDB=.docker/mysql/docker-entrypoint-initdb.d
HERE;

    }

    public function service()
    {
        return <<<HERE
  mysql:
    build:
      context: \${DOCKER_DIR}/mysql
    environment:
    - MYSQL_DATABASE=\${MYSQL_DATABASE}
    - MYSQL_USER=\${MYSQL_USER}
    - MYSQL_PASSWORD=\${MYSQL_PASSWORD}
    - MYSQL_ROOT_PASSWORD=\${MYSQL_ROOT_PASSWORD}
    - TZ=\${TIMEZONE}
    volumes:
    - \${DATA_PATH_HOST}/mysql:/var/lib/mysql
    - \${MYSQL_ENTRYPOINT_INITDB}:/docker-entrypoint-initdb.d
    ports:
    - "\${MYSQL_PORT}:3306"
    networks:
    - backend
    - frontend
HERE;
    }

    public function volume()
    {
        return '  '.$this->name.':'.PHP_EOL.'    driver: local'.PHP_EOL;
    }

    public function afterHandle()
    {
        $this->replaceInFile('.env', 'DB_HOST=127.0.0.1', 'DB_HOST=mysql');
    }

}