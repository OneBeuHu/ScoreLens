<?php

namespace onebeuhu\scorelens;

use onebeuhu\scorelens\command\HideScoreboardCommand;
use onebeuhu\scorelens\listener\EventListener;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{

    /**
     * @return void
     */
    protected function onEnable(): void
    {
        $server = $this->getServer();

        $server->getPluginManager()->registerEvents(new EventListener(), $this);

        $server->getCommandMap()->register('scorelens', new HideScoreboardCommand());
    }

}
