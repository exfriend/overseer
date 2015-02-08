<?php namespace Exfriend\Overseer\Models;

class CronjobRepo {
    public function getAllActive()
    {
        return Cronjob::where( 'active', '=', '1' )->get();
    }
} 