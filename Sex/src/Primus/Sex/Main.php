<?php
namespace Primus\Sex;

use Primus\Sex\event\PlayerSexSuccesfulEvent;
use Primus\Sex\event\PlayerSexFailedEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;


class Main extends PluginBase {
  
  public $cooldown;
  public $player;
  public $victim;
  
  protected $lang;
  
  const PREFIX = '[SEX]'; // PREFIX SHOULD BE CONFIGURED THROUGH CONFIG
  const LANGUAGE = 'en';
  
  public function onEnable(){
    $this->cooldown = array();
    $this->createLanguageFile();
    $this->getServer()->getPluginManager()->registerEvents(EventListener($this), $this);
  }
  public function onDisable(){
    
  }
  
  public function onCommand(CommandSender $sender, Command $command, $labe, array $args){
    if(strtolower($command->getName()) === 'sex'){
      if(isset($args[0])){
       $player = $this->getServer()->getPlayer($args);
       if($player instanceof Player){
          $cooldown = (isset($this->cooldown[$sender]) ? $this->cooldown[$sender->getName()] : time()); // Will work?
           if($this->cooldown[$sender->getName()] <= time()){ // <= !! <
            if($this->getChance()){
              // HAVE SEX xD
              $this->player = $sender;
              $this->victim = $player;
              $this->getServer()->getPluginManager()->callEvent(new PlayerSexSuccesfulEvent($sender, $player));
              return true;
            }else{
              $this->player = $sender;
              $this->victim = $player;
              $this->getServer()->getPluginManager()->callEvent(new PlayerSexFailedEvent($sender, $player));
            }
            }else{
             $sender->sendMessage(self::PREFIX.' Relax you need to chill');
             return true;
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

  public function getChance($type='undefined'){
    $type = $type === 'undefined' ? $type = $this->cfg['DefaultChance'] : $type;
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
    default:
      return false;
      $this->getLogger()->alert('Invalid chance given inside config');
      break;
    }
    }
    
    public function createLanguageFile(){
      switch(self::LANGUAGE){
        case "en":
      $lang = array(
        'SexSuccesful' => '{PLAYER} made baby with {VICTIM}.',
        'SexFailed' => '{PLAYER} tried to have sex with {VICTIM} but failed'
        'Cooldown' => 'Relax, you need to chill',
        );
      $this->lang = new Config($this->getDataFolder()."language.en". Config::YAML, $lang);
      return true;
      break;
      }
    }
    
    public function getLang($needle){
      // Logger::ALERT instead ??
      if($this->lang === null) return '[!] Could not load language file';
      $res = $this->lang->get($needle);
      if($res){
       $msg = str_replace(['{PLAYER}, {VICTIM}'], [$this->player, $this->victim], $res);
       return $msg;
      }else{
       return '[!] Could not find \''.$needle.'\' was not found in language file' ;
      }
      }
   
}
