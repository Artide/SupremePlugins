
 <?php
namespace Primus\IceTool;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerJoinEvent;
use Primus\IceTool\events\PlayerFreezeEvent;
use Primus\IceTool\events\PlayerUnfreezeEvent;

class EventListener implements Listener{
	
	protected $plugin;
	
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}
	
	protected function getMain(){
		return $this->plugin;
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$this->getMain()->refreshPlayer($player);
	}
	
	public function onFreeze(PlayerFreezeEvent $event){
		$player = $event->getPlayer();
		if(true){ // <-- ADD PERMISSION ice.be.freezed
		$this->getMain()->freeze($player);
		}
	}
	
	public function onUnfreeze(PlayerUnfreezeEvent $event){
		$player = $event->getPlayer();
		if(true){ // <-- ADD PERMISSION ice.be.unfreezed
		$this->getMain()->unfreeze($player);
		}
		if($this->getMain()->cfg['SendUnfreezeMessage']){
			$player->sendMessage(Main::PREFIX." You have been warmed up");
		}
		}
	}
	
	public function onMove(PlayerMoveEvent $event){
		$player = $event->getPlayer();
	if($this->getMain()->isFrozen($player)){ // <-- ADD PERMISSION ice.be.frozen
		if($event->getTo() == $event->getFrom() and $this->getMain()->cfg['AllowLookAround']){ // <-- ADD PERMISSION ice.look.around
			$event->setCancelled(true);
			$player->sendPopup(Main::PREFIX." You're frozen"); // <-- ADD TIME LEFT
		}
		}
	/*
	*  AREAS
	*/
	}
}
