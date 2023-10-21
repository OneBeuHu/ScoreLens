<?php

namespace onebeuhu\scorelens\command;

use onebeuhu\scorelens\board\BoardManager;
use onebeuhu\scorelens\utils\SoundPlayer;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;

class BoardCommand extends Command
{

    public function __construct()
    {
        parent::__construct(
            "board",
            "Hide/Show ScoreBoard"
        );
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if(!$sender instanceof Player)
        {
            return false;
        }

        /** @var Player $sender */
        if(!BoardManager::hasBoard($sender))
        {
            $sender->sendMessage("You have nothing to hide");
            SoundPlayer::sendToPlayer($sender, "note.bassattack");
            return false;
        }

        $board = BoardManager::getBoard($sender);

        if($board->isHidden())
        {
            $board->show();
            $sender->sendMessage("The ScoreBoard was successfully displayed");
        }
        else
        {
            $board->hide();
            $sender->sendMessage("The ScoreBoard was successfully hidden");
        }

        SoundPlayer::sendToPlayer($sender, "random.orb");
        return true;
    }
}