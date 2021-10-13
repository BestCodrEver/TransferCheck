<?php

namespace BestCodrEver\TransferCheck;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class CommandLoader extends PluginBase {

    public function onEnable(){
        $commandMap = Server::getInstance()->getCommandMap();
        $commandMap->unregister($commandMap->getCommand('transferserver'));
    }
    
}