<?php

namespace onebeuhu\scorelens\listener;

use onebeuhu\scorelens\board\BoardManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener
{

    /**
     * @param PlayerQuitEvent $event
     * @return void
     */
    public function onPlayerQuit(PlayerQuitEvent $event) : void
    {
        $player = $event->getPlayer();
        if(BoardManager::hasBoard($player))
        {
            $board = BoardManager::getBoard($player);
            $board->remove();
        }
    }
}