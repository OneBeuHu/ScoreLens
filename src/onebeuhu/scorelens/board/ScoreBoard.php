<?php

namespace onebeuhu\scorelens\board;

use onebeuhu\scorelens\manager\MethodManager;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;
use pocketmine\Server;

class ScoreBoard
{

    /**
     * @var string
     */
    protected string $scoreboardName = "";

    /**
     * @var int
     */
    protected int $lineCount = 0;

    /**
     * @var int
     */
    protected int $scoreboardId = 0;

    /**
     * @var array
     */
    protected array $contents = [];

    /**
     * @param string $scoreboardName
     * @param int $lineCount
     */
    public function __construct(string $scoreboardName, int $lineCount)
    {

        $this->scoreboardName = $scoreboardName;

        if($lineCount > 16)
        {
            Server::getInstance()->getLogger()->critical("You tried to create a scoreboard with more than 16 lines");
        }
        $this->lineCount = $lineCount;

        for ($line = 1; $line <= $lineCount; $line++)
        {

            $this->setLine($line, str_repeat(" ", $line));
        }
    }

    /**
     * Sends a scoreboard to the player if possible
     *
     * @return void
     */
    public function sendTo(Player $player) : void
    {
        $name = $player->getName();

        if(!MethodManager::getInstance()->isHideList($name))
        {
			MethodManager::getInstance()->removeScoreBoard($player, $name);

            $pk = new SetDisplayObjectivePacket();
            $pk->displaySlot = $pk::DISPLAY_SLOT_SIDEBAR;
            $pk->objectiveName = $name;
            $pk->displayName = $this->scoreboardName;
            $pk->criteriaName = "dummy";
            $pk->sortOrder = 0;

            $player->getNetworkSession()->sendDataPacket($pk);

            $lines = 1;

            foreach ($this->contents as $content)
            {

                $entries = new ScorePacketEntry();
                $entries->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
                $entries->objectiveName = $name;
                $entries->customName = $content;
                $entries->score = $lines;
                $entries->scoreboardId = $this->scoreboardId;

                $pk = new SetScorePacket();
                $pk->type = 0;
                $pk->entries[] = $entries;
                $player->getNetworkSession()->sendDataPacket($pk);

                $this->scoreboardId++;
                $lines++;
            }
        }
    }

    /**
     * Changes the line on the selected line to $content
     *
     * @param int $lineNumber
     * @param string $content
     * @return void
     */
    public function setLine(int $lineNumber, string $content) : void
    {
        if($lineNumber > $this->lineCount)
        {
            Server::getInstance()->getLogger()->warning("You are trying to change line number " . $lineNumber . " even though there are only " . $this->lineCount);

            return;
        }

        $this->contents[$lineNumber] = $content;
    }

}