<?php
namespace primus\lobbytool;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
  
  public $config
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->saveDefaultConfig();
    $this->config = $this->getConfig()->getAll();
    //msg
  }
  public function onDisable(){
    $this->getConfig()->save();
    //msg
  }
  
  public function onTap(PlayerInteractEvent $event){
    $player = $event->getPlayer();
    $item = $event->getItem();
  }
  
  public function executeCommands(Player $player, array $commands){
    foreach($commands as $command){
      $this->getServer()->dispatchCommand($player, $command);
    }
    return true;
  }
  
}
