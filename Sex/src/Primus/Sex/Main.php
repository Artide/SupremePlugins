<?php
namespace Primus\Sex;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;


class Main extends PluginBase {
  
  public $cooldown;
  const PREFIX = '[SEX]'; // PREFIX SHOULD BE CONFIGURED THROUGH CONFIG
  
  public function onEnable(){
    $this->cooldown = array();
  }
  public function onDisable(){
    
  }
  
  public function onCommand(CommandSender $sender, Command $command, $labe, array $args){
    if(strtolower($command->getName()) === 'sex'){
      if(isset($args[0])){
       $player = $this->getServer()->getPlayer($args);
       if($player instanceof Player){
          if(isset($this->cooldown[$sender->getName()])){
           if($this->cooldown[$sender->getName()] < time()){
            if($this->getChance()){
              // HAVE SEX xD
            }
            }else{
             $sender->sendMessage(self::PREFIX.' Relax you need to chill');
             return true;
            }
           }else{
             // COOLDOWN NOT ADDED
           }
           }else{
            $sender->sendMessage(self::PREFIX.' '.$args[0].' was not found on server'); 
           }
           }else{
            $sender->sendMessage(self::PREFIX.' Enter player you want to have sex with');
            return false;
           }
    }
  }

  public function getChance($type='small'){
    switch($type){
     case 'small':
       if(rand(1, 10) === 5) return true;
       return false;
       break;
    case 'medium':
      if(rand(1, 5) === 3) return true;
      return false;
      break;
    case 'big':
      if(rand(1, 3) === 1) return true;
      return false;
      break;
    case 'sure':
      return true;
      break;
    }
    }

}
