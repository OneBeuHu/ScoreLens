<?php

namespace onebeuhu\scorelens;

use onebeuhu\scorelens\command\BoardCommand;
use onebeuhu\scorelens\listener\EventListener;
use onebeuhu\scorelens\task\UpdateBoardTask;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{
    /**
     * @return void
     */
    protected function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->register("scorelens", new BoardCommand());
    }
}