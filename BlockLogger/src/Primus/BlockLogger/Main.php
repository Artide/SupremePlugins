<?php
namespace Primus\BlockLogger;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\Config;

class Main extends PluginBase {

  public $blocks;
  
  public function onEnable(){
  $this->blocks = (new Config($this->getDataFolder()."blocks.yml", Config::YAML))->getAll();
  $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
  $this->getLogger()->info('Enabled');
  }
  public function onDisable(){
  $this->blocks = new Config($this->getDataFolder()."blocks.yml", Config::YAML, $this->blocks);
  $this->getLogger()->info('Disabled');
  }
  



}
