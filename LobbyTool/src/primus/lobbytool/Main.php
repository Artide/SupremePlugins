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
    $block = $event->getBlock();
    if($block->getFloorX() == $player->getFloorX() || $block->getFloorZ() == $player->getFloorZ() || $block->getFloorY() > $player->getFloorY()){ // Touches block above himself
      if(array_key_exists($item->getId(), $this->config['items'])){
        $this->executeCommands($player, $this->config['items'][$item->getId()]);
      }
    }
  }
  
  public function executeCommands(Player $player, array $commands){
    foreach($commands as $command){
      $this->getServer()->dispatchCommand($player, $command);
    }
    return true;
  }
  
}
