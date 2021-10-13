<?php

namespace BestCodrEver\TransferCheck;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use BestCodrEver\TransferCheck\TransferCommand;

class CommandLoader extends PluginBase {

    public function onEnable(){
        $commandMap = Server::getInstance()->getCommandMap();
        $commandMap->unregister($commandMap->getCommand('transferserver'));
        $commandMap->registerCommands($plugin->getName(), new TransferCommand($plugin));
    }
    
}
