
 <?php
namespace Primus\IceTool;

use Primus\IceTool\events\PlayerFreezeEvent;
use Primus\IceTool\events\PlayerUnfreezeEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;

class Main extends PluginBase {
	
	protected $players;
	
	const PREFIX = "[IcE]"; // <-- Make it editable ?
	
	public function onEnable(){
		$this->players = array();
		$eventListener = new EventListener($this);
		$this->getServer()->getPluginManager()->registerEvents($eventListener, $this);
		foreach($this->getServer()->getOnlinePlayers() as $ps){
			$this->players[$ps->getName()] = $this->isFrozen($ps);
		}
		
		if(!file_exists($this->getDataFolder()."Config.yml")){
			$default = array(
				"AllowLookAround" => true,
				"SendUnfreezeMessage" => true,
				"PopupDuration" => 2, // IMPLEMENT
				"EnableParticle" => true,
				"EnableSound" => true
				);
			$this->cfg = (new Config($this->getDataFolder()."Config.yml", Config::YAML, $default))->getAll();
		}else{
			$this->cfg = (new Config($this->getDataFolder()."Config.yml", Config::YAML))->getAll();		
		}
		
		$this->getLogger()->info("Enabled.");
	}
	
	public function onDisable(){
		$this->getLogger()->info("Disabled.");
	}
	
	public function getPlayers(){
		return $this->players;
	}
	
	public function isFrozen($name){
		$name = $name instanceof Player ? $name->getName() : $name;
		if(isset($this->players[$name])){
			return $this->players[$name];
		}else{
			return false;
		}
	}
	
	public function freeze($name){
		$name = $name instanceof Player ? $name->getName() : $name;
		$this->players[$name] = true;
		return $this->isFrozen($name);
	}
	
	public function unfreeze($name){
		$name = $name instanceof Player ? $name->getName() : $name;
		$this->players[$name] = false;
		return $this->isFrozen($name)  === false;
	}
	
	public function refreshPlayer($name){ // Maby addPlayer();
		$name = $name instanceof Player ? $name->getName() : $name;
		if(isset($this->players[$name])) return;
		$this->players[$name] = false;
	}
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch(strtolower($command->getName())){
			case "ice":
			if(isset($args[0])){
				switch(strtolower($args[0])){
			//////////////// FREEZE ////////////////////
					case "freeze":
					case "frz":
					if(isset($args[1])){
						$player = $this->getServer()->getPlayer($args[1]);
						$world = $this->getServer()->getLevelByName($args[1]);
						if($player instanceof Player){
							$this->getServer()->getPluginManager()->callEvent(new PlayerFreezeEvent($player));
							if($this->isFrozen($player)) $sender->sendMessage(self::PREFIX." You've frozed ". $player->getName());
							return true;
						}elseif($world instanceof Level){
							$players = $world->getPlayers();
							foreach($players as $player){
							if(true){ // <-- Add permission to not be frozen	
										$this->getServer()->getPluginManager()->callEvent(new PlayerFreezeEvent($player));
									}
								}
							$sender->sendMessage(self::PREFIX." You have frozen all players inside ".$level->getName()." world");
							return true;
							}
							}else{
							$sender->sendMessage(self::PREFIX." Player not found");
							return true;
						}
					}else{
						$sender->sendMessage(self::PREFIX.' Usage:');
						$sender->sendMessage'  /ice <freeze|frz> <player|world>');
						return true;
					}
					break;
			//////////////// UNFREEZE ///////////////////
					case "unfreeze":
					case "unfrz":
					if(isset($args[1])){
						$player = $this->getServer()->getPlayer($args[1]);
						if($player instanceof Player){
							$this->getServer()->getPluginManager()->callEvent(new PlayerUnfreezeEvent($player));
							if($this->isFrozen($player)) $sender->sendMessage(self::PREFIX." You have warmed ". $player->getName());
							return true;
						}else{
							$sender->sendMessage(self::PREFIX." Player not found");
							return true;
						}
					}else{
						$sender->sendMessage(self::PREFIX.' Usage:');
						$sender->sendMessage'  /ice <unfreeze|unfrz> <player|world>');
						return true;
					}
					break;
			/////////////// FROZENAXE /////////////////
				}
			}else{
				$sender->sendMessage(self::PREFIX.' Commands:');
				$sender->sendMessage'  /ice <freeze|frz> <player|world>');
				$sender->sendMessage('  /ice <area> <create|del|update> <name>');
				$sender->sendMessage('  /ice <frozenaxe> [on|off]');
				$sender->sendMessage(self::PREFIX.' ============================');
				return true;
			}
			break;
			default:
			// Help pages
			$sender->sendMessage("Command not found");
			return true;
		}
	}
	
}
