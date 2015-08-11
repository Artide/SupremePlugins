
 <?php
namespace Primus\IceTool\events;

use pocketmine\event\player\PlayerEvent;
use pocketmine\Player;
use Primus\IcyManager\Main;

class PlayerFreezeEvent extends PlayerEvent{
	
	public static $handlerList = null;
	public static $nextEvent = 0;
	public static $eventPool = array();
	
	protected $eventName = null;
	protected $player;
	protected $time; // TODO
	protected $isFrozen = true;
	
	public function __construct(Player $player, $freeze=true){
		$this->player = $player;
		$this->isFrozen = $freeze;
	}
	
	public function getPlayer(){
		return $this->player;
	}
	
	public function isFrozen(){
		return $this->isFrozen;
	}
	
	public function getHandlers(){
		return $this::$handlerList;
	}
}
