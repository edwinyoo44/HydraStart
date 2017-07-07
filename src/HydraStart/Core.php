<?php
namespace HydraStart;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\utils\Config;

use pocketmine\plugin\PluginBase;

class Core extends PluginBase{
	
	public static $instance;
	
	public static $timer;
	
	public function onLoad(){
	    $this->checkFiles();
	}
	
	public function onEnable(){
	    $this->getLogger()->info("§aRestarter is enabled");
	    $this->startup();
	}
	
	public function checkFiles(){
	    $this->saveDefaultConfig();
	}
	
	public function getSettings($key){
	    $this->getConfig()->reload();
	return $this->getConfig()->get($key);
	}
	
	public function startup(){
	     self::$instance = $this;
	     self::$timer = new Tasks\RestartTask($this->getSettings("restart.time") * 60);
	     $this->getServer()->getScheduler()->scheduleRepeatingTask(self::$timer, 20);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new Tasks\CountDown(), 20 * 60);
	}
	
	public static function getInstance(){
	    return self::$instance;
	}
	
	public function processShutDown(){
		$players = $this->getServer()->getOnlinePlayers();
		if(count($players) == 0){
			$this->getServer()->shutdown();
		}
	   foreach($players as $player){
		  if($this->getSettings("reconnector") == true){
	      $pk = new \pocketmine\network\protocol\TransferPacket();
	      $pk->address = $this->getServer()->getIp();
	      $pk->port = $this->getServer()->getPort();
	      $player->dataPacket($pk);
	     }
	    $this->getServer()->shutdown($this->getSettings("close.msg"));
	   }
	}
}