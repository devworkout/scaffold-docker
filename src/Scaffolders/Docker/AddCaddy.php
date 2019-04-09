<?php


namespace DevWorkout\ScaffoldDocker\Scaffolders\Docker;


class AddCaddy extends AddService
{
    protected $question = 'Add Caddy?';

    protected $name = 'caddy';

    public function env()
    {
        $cwd = getcwd();
        return <<<HERE
CADDY_CONFIG_PATH=.docker/caddy/caddy
CADDY_HOST_LOG_PATH=$cwd/storage/logs/caddy
CADDY_HOST_HTTP_PORT=80
CADDY_HOST_HTTPS_PORT=443
HERE;

    }

    public function service()
    {
        return <<<HERE
  caddy:
    build:
      context: \${DOCKER_DIR}/caddy
    volumes:
    - /mnt:/mnt
    - \${APP_CODE_PATH_HOST}:\${APP_CODE_PATH_CONTAINER}
    - \${CADDY_CONFIG_PATH}:/etc/caddy
    - \${CADDY_HOST_LOG_PATH}:/var/log/caddy
    - \${DATA_PATH_HOST}:/root/.caddy
    ports:
    - "\${CADDY_HOST_HTTP_PORT}:80"
    - "\${CADDY_HOST_HTTPS_PORT}:443"
    depends_on:
    - php-fpm
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