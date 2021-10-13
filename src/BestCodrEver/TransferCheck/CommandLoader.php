<?php

namespace BestCodrEver\TransferCheck;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use BestCodrEver\TransferCheck\TransferCommand;

class CommandLoader extends PluginBase {

    public function onEnable(){
        $commandMap = Server::getInstance()->getCommandMap();
        $command = $commandMap->getCommand('transferserver');
        if($command !== null){
          $commandMap->unregister($command);
        }
        $commandMap->register('transferserver', new TransferCommand($this));
    }
    
}
