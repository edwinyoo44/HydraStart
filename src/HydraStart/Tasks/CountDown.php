<?php
namespace HydraStart\Tasks;

use pocketmine\scheduler\PluginTask;

use HydraStart\Core;

class CountDown extends PluginTask{

	public function __construct(){
		 $this->core = Core::getInstance();
	    parent::__construct($this->core);
	}
	
	public function getCore(){
	    return $this->core;
	}
	
	public function onRun($tick){
	    $this->getCore()->getServer()->broadcastMessage($this->translate($this->getCore()->getSettings("restart.msg")."§r"));
	}
	
	public function translate(string $str){
		  $time = (round(RestartTask::$time / 60, 0, PHP_ROUND_HALF_ODD));
	 return str_replace(["{time}", "&"], [$time, "§"], $str);
	}
}