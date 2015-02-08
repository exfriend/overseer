<?php


namespace Exfriend\Overseer\Procedures;


interface ProcedureInterface {

    public function run();

    public function checkpoint();

    public function setProgress( $percent );
}