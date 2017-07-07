<?php
namespace HydraStart\Tasks;

use pocketmine\scheduler\PluginTask;

class RestartTask extends PluginTask{
     
	  public static $time = 0;
	
	  public function __construct(int $time){
	      self::$time = $time;
	      $this->core = \HydraStart\Core::getInstance();
	      parent::__construct($this->core);
	  }
	
	  public function getCore(){
	      return $this->core;
	  }
	
	  public function onRun($tick){
	      self::$time--;
	      if(self::$time < $this->getCore()->getSettings("countdown.time")){
		     $this->getCore()->getServer()->broadcastMessage("§l||§r§7 Restarting in ".self::$time);
		   }
	      if(self::$time == 0){
	        $this->getCore()->processShutDown();
         }
     }
}