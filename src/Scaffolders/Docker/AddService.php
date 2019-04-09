<?php

namespace DevWorkout\ScaffoldDocker\Scaffolders\Docker;


use Afterflow\Framework\Scaffolder;

abstract class AddService extends Scaffolder
{
    protected $name;

    public function handle()
    {
        $this->command->line('Adding '.$this->name);
        $this->copyStub(__DIR__.'/../../../stubs', '.docker/'.$this->name);

        $stuff = [
            'env' => $this->env(),
            'service' => $this->service(),
            'volume' => $this->volume(),
        ];
        $this->afterHandle();
        return $stuff;
    }

    public function env()
    {
        return null;
    }

    public function volume()
    {
        return null;
    }

    protected function afterHandle()
    {
        // Override
    }
}