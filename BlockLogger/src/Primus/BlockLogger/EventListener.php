<?php
namespace Primus\BlockLogger;

use pocketmine\event\Listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;

class EventListener implements Listener{

  protected $plugin;

  public function __construct(Main $plugin){
  $this->plugin = $plugin;
  }
  
  public function onBlockBreak(BlockBreakEvent $event){
  $player = $event->getPlayer();
  $block = $event->getBlock();
  if($player->hasPermission('log.breaked.block')){
    $this->plugin->addBreakedBlock($block, $player); // ADD TIME
  }
  }
  
  public function onBlockPlace(BlockPlaceEvent $event){
  $player = $event->getPlayer();
  $block = $event->getBlock();
  if($player->hasPermission('log.placed.block')){
    $this->plugin->addPlacedBlock($block, $player); // ADD TIME
  }
  }

}
