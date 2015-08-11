<?php
namespace Primus\IceTool\events;

use pocketmine\event\player\PlayerEvent;
use pocketmine\Player;
use Primus\IceTool\Main;

class PlayerUnfreezeEvent extends PlayerEvent{
	
	public static $eventPool = array();
	public static $nextEvent = 0;
	public static $handlerList = null;
	
	protected $player;
	protected $eventName = null;
	
	public function __construct(Player $player){
		$this->player = $player;
	}
	
	public function getPlayer(){
		return $this->player;
	}
	
	public function getHandlers(){
		return $this->handlerList;
}
} 
