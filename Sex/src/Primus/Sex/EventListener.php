<?php
namespace Primus\Sex;

use pocketmine\event\Listener; 
use pocketmine\Player;

use Primus\Sex\event\PlayerSexSuccesfulEvent;
use Primus\Sex\event\PlayerSexFailedEvent;

class EventListener implements Listener{

  protected $plugin;
  
  public function __construct(Main $plugin){
   $this->plugin = $plugin;
  }
  
  public function onSexSucces(PlayerSexSuccesfulEvent $event){
  
  {
  
  public function onSexFailed(PlayerSexFailedEvent $event){
  
  }

}
