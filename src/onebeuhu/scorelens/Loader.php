<?php

namespace onebeuhu\scorelens;

use onebeuhu\scorelens\command\HideScoreboardCommand;
use onebeuhu\scorelens\listener\EventListener;
use onebeuhu\scorelens\manager\MethodsManager;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{

    /**
     * @return void
     */
    protected function onEnable(): void
    {
        $server = $this->getServer();

        $methods = new MethodsManager($server);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($methods), $this);

        $server->getCommandMap()->register('player', new HideScoreboardCommand());
    }

}