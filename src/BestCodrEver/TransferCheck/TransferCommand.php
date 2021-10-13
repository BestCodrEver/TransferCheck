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

		$sender->transfer($args[0], (int) ($args[1] ?? 19132));

		return true;
	}

}