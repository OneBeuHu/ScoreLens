<?php

namespace onebeuhu\scorelens\command;

use onebeuhu\scorelens\manager\MethodsManager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class HideScoreboardCommand extends Command
{

    public function __construct()
    {
        parent::__construct("hsc", "Hide/Show Scoreboard", null, ["hscore"]);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return mixed|void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player)
        {
            MethodsManager::getInstance()->changeScoreboardStatus($sender);
        }
    }

}