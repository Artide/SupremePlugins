
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
		$this->getMain()->freeze($player);
		echo "Freezed";
	}
	
	public function onUnfreeze(PlayerUnfreezeEvent $event){
		$player = $event->getPlayer();
		$this->getMain()->unfreeze($player);
		echo "Unfreezed";
	}
	
	public function onMove(PlayerMoveEvent $event){
		$player = $event->getPlayer();
		if($this->getMain()->isFrozen($player) || $player->hasPermission('ice.freeze.me')){
			echo "Frozen";
			if($event->getFrom() == $event->getTo()){
				echo "Frozennn"
				$event->setCancelled(true);
				$player->sendPopup("You're frozen", 2);
			}else{
				echo $event->getFrom().' != '.$event->getTo();
			}
		}else{
			echo 'Player is not frozen or he does not have permission';
		}
	}
	
}
