<?php

namespace App\Policys;
use App\Contracts\LogInterface;
use think\facade\Log;

class ThinkLog implements LogInterface
{
    public $Log;

    function __construct()
    {
        $this->Log = new Log();
        $this->Log::init([
            'default'	=>	'file',
            'channels'	=>	[
                'file'	=>	[
                    'type'	=>	'file',
                    'path'	=>	'./logs/',
                ],
            ],
        ]);
    }

    public function info($message)
    {
        $this->Log::info($message);
        $this->save();
    }

    public function debug($message)
    {
        $this->Log::debug($message);
        $this->save();
    }

    public function error($message)
    {
        $this->Log::error($message);
        $this->save();
    }

    public function save()
    {
        $this->Log::save();
    }
}

