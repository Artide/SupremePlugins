<?php
namespace primus\chesttag;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\Block;
use pocketmine\Player;

class CTMain extends PluginBase {

  protected $chests;
  protected $tagedChests;

  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents(CTListener($this), $this);
    $this->chests = (new Config($this->getDataFolder()."chests.yml", Config::YAML))->getAll();
    $this->tagedChests = (new Config($this->getDataFolder()."taged_chests.yml", Config::YAML))->getAll();
  }
  public function onDisable(){
    $this->chests = new Config($this->getDataFolder()) // CONTINUE FROM HERE
  }
  
  public function getChests(){
  return $this->chests;
  }
  
  public function getTagedChests(){
  return $this->tagedChests;
  }
  
}
