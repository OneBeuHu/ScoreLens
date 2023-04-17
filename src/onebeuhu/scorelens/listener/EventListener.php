<?php

namespace onebeuhu\scorelens\listener;

use onebeuhu\scorelens\manager\MethodManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener
{
    /**
     * @param PlayerQuitEvent $event
     * @return void
     */
    public function playerQuit(PlayerQuitEvent $event) : void
    {
        $name = $event->getPlayer()->getName();

        if(MethodManager::getInstance()->isHideList($name))
		{
			MethodManager::getInstance()->unsetHideList($name);
		}
    }
}