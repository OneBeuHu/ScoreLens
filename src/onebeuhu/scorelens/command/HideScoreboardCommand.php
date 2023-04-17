<?php

namespace onebeuhu\scorelens\command;

use onebeuhu\scorelens\manager\MethodManager;
use onebeuhu\scorelens\utils\Utils;
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
			$name = $sender->getName();

			if(MethodManager::getInstance()->isHideList($name))
			{
				MethodManager::getInstance()->unsetHideList($name);

				$sender->sendMessage("§cYou returned the scoreboard to hide it, write the same command again.");
				Utils::sendSoundToPlayer($sender, "note.bassattack");
			}
			else
			{
				MethodManager::getInstance()->removeScoreBoard($sender, $name);

				MethodManager::getInstance()->addInHideList($name);

				$sender->sendMessage("§aYou have hidden the ScoreBoard, to get it back, write the same command again.");
				Utils::sendSoundToPlayer($sender, "random.orb");
			}
        }
    }

}