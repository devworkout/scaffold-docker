<?php

namespace DevWorkout\ScaffoldDocker\Scaffolders;

use Afterflow\Framework\Concerns\RunsScaffolders;
use Afterflow\Framework\Scaffolder;
use DevWorkout\ScaffoldDocker\Scaffolders\Docker\AddCaddy;
use DevWorkout\ScaffoldDocker\Scaffolders\Docker\AddMySQL;
use DevWorkout\ScaffoldDocker\Scaffolders\Docker\AddPhp;
use DevWorkout\ScaffoldDocker\Scaffolders\Docker\AddPhpMyAdmin;
use DevWorkout\ScaffoldDocker\Scaffolders\Docker\AddWorker;
use DevWorkout\ScaffoldDocker\Scaffolders\Docker\AddWorkspace;
use File;

class ScaffoldDocker extends Scaffolder
{
    use RunsScaffolders;

    protected $env;
    protected $envInsert;
    protected $dockerComposeVolumes = 'volumes:'.PHP_EOL;
    protected $dockerComposeServices = 'services:'.PHP_EOL;

    protected $question = 'Scaffold Docker?';

    public function handle()
    {
        File::deleteDirectory('.docker');

        $dockerDirExists = file_exists('.docker');
        if ($dockerDirExists) {
            $this->command->error('.docker directory already exists in '.getcwd());
            return 0;
        }

        $this->env = trim(file_get_contents('.env'));
        if (strpos($this->env, '# AFTERGLOW_START') !== false) {
            $this->env = trim(substr($this->env, strpos($this->env, '# AFTERGLOW_END') + 15));
        }

        $this->command->line('Initializing docker');
        $this->initDocker();

        $scafs = $this->runScaffolders([
            AddWorkspace::class,
            AddPhp::class,
            AddCaddy::class,
            AddMySQL::class,
            AddPhpMyAdmin::class,
            AddWorker::class,
        ]);

        foreach ($scafs as $s) {
            $this->envInsert .= $s['env'].PHP_EOL;
            $this->dockerComposeVolumes .= $s['volume'];
            $this->dockerComposeServices .= $s['service'].PHP_EOL.PHP_EOL;
        }

        $this->finish();

        if ($this->command->confirm('Add docker-compose shortcuts?', true)) {
            file_put_contents('./up', 'sudo docker-compose up -d --build');
            file_put_contents('./down', 'sudo docker-compose down');
            file_put_contents('./w', 'sudo docker-compose exec --user=laradock workspace bash');
        }

        return;
    }


    public function initDocker()
    {
        mkdir('.docker');

        $this->envInsert = implode([
            'TIMEZONE=Europe/Kiev',
            'APP_CODE_PATH_HOST=../'.basename(getcwd()).'/',
            'APP_CODE_PATH_CONTAINER=/var/www:cached',
            'DATA_PATH_HOST=~/.afterflow/'.basename(getcwd()).'_data',
            'DOCKER_HOST_IP=10.0.75.1',
            'DOCKER_DIR=../'.basename(getcwd()).'/.docker',
        ], PHP_EOL);
    }

    public function finish()
    {
        info('Finishing');

        $compose = implode([
            "version: '3'",
            "networks:",
            "  frontend:",
            "    driver: bridge",
            "  backend:",
            "    driver: bridge",
        ], PHP_EOL);

        file_put_contents('docker-compose.yml',
            $compose.PHP_EOL.$this->dockerComposeVolumes.PHP_EOL.$this->dockerComposeServices);
        file_put_contents('.env', '# AFTERGLOW_START'.PHP_EOL.$this->envInsert.'# AFTERGLOW_END'.PHP_EOL.$this->env);

    }


}