<?php

namespace onebeuhu\scorelens\listener;

use onebeuhu\scorelens\manager\MethodsManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener
{

    /**
     * @var MethodsManager|null
     */
    protected ?MethodsManager $methodsManager = null;

    /**
     * @param MethodsManager $methodsManager
     */
    public function __construct(MethodsManager $methodsManager)
    {
        $this->methodsManager = $methodsManager;
    }

    /**
     * @param PlayerQuitEvent $event
     * @return void
     */
    public function playerQuit(PlayerQuitEvent $event) : void
    {
        $name = $event->getPlayer()->getName();

        if($this->methodsManager->isHideList($name))
        {
            $this->methodsManager->unsetHideList($name);
        }
    }
}