
 <?php
namespace Primus\IceTool;

use Primus\IceTool\events\PlayerFreezeEvent;
use Primus\IceTool\events\PlayerUnfreezeEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

class Main extends PluginBase {
	
	protected $players;
	
	public function onEnable(){
		$this->players = array();
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		foreach($this->getServer()->getOnlinePlayers() as $ps){
			$this->players[$ps->getName()] = $this->isFrozen($ps);
		}
		$eventListener = new EventListener($this);
		$this->getLogger()->info("Enabled.");
	}
	
	public function onDisable(){
		$this->getLogger()->info("Disabled.");
	}
	
	public function getPlayers(){
		return $this->players;
	}
	
	public function isFrozen($name){
		if($name instanceof Player){
			$name = $name->getName();
		}
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
	
	public function refreshPlayer($name){
		$name = $name instanceof Player ? $name->getName() : $name;
		if(isset($this->players[$name])) return;
		$this->players[$name] = false;
	}
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch(strtolower($command->getName())){
			case "ice":
			if(isset($args[0])){
				switch(strtolower($args[0])){
					case "freeze":
					case "frz":
					if(isset($args[1])){
						$player = $this->getServer()->getPlayer($args[1]);
						if($player instanceof Player){
							$this->freeze($player);
							$sender->sendMessage("[IcE] You've frozed ". $player->getName());
							$this->getServer()->getPluginManager()->callEvent(new PlayerFreezeEvent($player));
						}else{
							$sender->sendMessage("[IcE] Player not found");
							return true;
						}
					}else{
						return false; // Usage
					}
				}
			}else{
				$sender->sendMessage("Enter a sub command");
				// Help page
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
