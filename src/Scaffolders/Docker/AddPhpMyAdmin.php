<?php


namespace DevWorkout\ScaffoldDocker\Scaffolders\Docker;


class AddPhpMyAdmin extends AddService
{
    protected $question = 'Add phpMyAdmin?';

    protected $name = 'phpmyadmin';

    public function env()
    {
        return <<<HERE
PMA_DB_ENGINE=mysql
PMA_USER=homestead
PMA_PASSWORD=secret
PMA_ROOT_PASSWORD=secret
PMA_PORT=8081
PMA_HOST=mysql
HERE;

    }

    public function service()
    {
        return <<<HERE
  phpmyadmin:
    build:
      context: \${DOCKER_DIR}/phpmyadmin
      args:
      - MSQT=\${PMA_HOST}
    environment:
    - PMA_ARBITRARY=1
    - MYSQL_USER=\${PMA_USER}
    - MYSQL_PASSWORD=\${PMA_PASSWORD}
    - MYSQL_ROOT_PASSWORD=\${PMA_ROOT_PASSWORD}
    ports:
    - "\${PMA_PORT}:80"
    depends_on:
    - "\${PMA_DB_ENGINE}"
    networks:
    - frontend
    - backend
HERE;
    }

    public function volume()
    {
        return '  '.$this->name.':'.PHP_EOL.'    driver: local'.PHP_EOL;
    }

}