<?php

namespace BestCodrEver\TransferCheck;

use pocketmine\command\Command;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\scheduler\AsyncTask;
use pocketmine\scheduler\TaskScheduler;
use pocketmine\Player;
use function count;
use libpmquery\PMQuery;
use libpmquery\PmQueryException;

class TransferCommand extends Command implements PluginIdentifiableCommand {

    public $plugin;
    
    public function __construct($plugin){
		parent::__construct(
			"transferserver",
			"%pocketmine.command.transferserver.description",
			"%pocketmine.command.transferserver.usage"
		);
		$this->setPermission("pocketmine.command.transferserver");
        $this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		if(count($args) < 1){
			throw new InvalidCommandSyntaxException();
		}elseif(!($sender instanceof Player)){
			$sender->sendMessage("This command must be executed as a player");
			return false;
		}

        $plugin->getServer()->getAsyncPool()->submitTask(new class($sender, $args) extends AsyncTask{
            public function __construct(Player $sender, $args)
                $this->storeLocal([$sender, $args]);
            }
            public function onRun(): void{
                $args = $this->fetchLocal()[1];
                try{
                    $query = PMQuery::query($args[0], (int) ($args[1] ?? 19132));
                    $this->setResult($query);
                }catch(PmQueryException $e){
                    $this->setResult("Error");
                }
            }
            public function onCompletion(Server $server): void{
                $query = $this->getResult();
                $player = $this->fetchLocal()[0];
                $args = $this->fetchLocal()[1];
                if($query === null) return;
                if ($query === "Error"){
                    $player->sendMessage("§cThat server is offline. Try again later.");
                    return;
                }else {
                    $sender->transfer($args[0], (int) ($args[1] ?? 19132));
                }
            }
        });

		return true;
	}

}