<?php


namespace Exfriend\Overseer\Procedures;


interface ProcedureInterface {

    public function handle();

    public function checkpoint();

    public function setProgress( $percent );
}