<?php

namespace Exfriend\Overseer\Procedures;


interface ProcedureInfoInterface {

    // -------------------------------------------------------------------
    // --[ Get info ]-----------------------------------------------------
    // -------------------------------------------------------------------

    public function getRunning();

    public function getProgress();

    public function getLocked();

    public function getLog();

    public function getStop();

    public function getInfo();

    // -------------------------------------------------------------------
    // --[ Set info ]-----------------------------------------------------
    // -------------------------------------------------------------------
    /*
        public function setRunning( bool $running );

        public function setProgress( int $progress );

        public function setLocked( bool $locked );

        public function setStop( bool $stop );
    */
}