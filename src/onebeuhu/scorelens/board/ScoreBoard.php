<?php

namespace onebeuhu\scorelens\board;

use onebeuhu\scorelens\manager\MethodsManager;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;

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
     * @var Player
     */
    protected Player $player;

    /**
     * @var MethodsManager
     */
    protected MethodsManager $methodsManager;

    /**
     * @var array
     */
    protected array $contents = [];

    /**
     * @param string $scoreboardName
     * @param int $lineCount
     * @param Player $player
     */
    public function __construct(string $scoreboardName, int $lineCount, Player $player)
    {

        $this->methodsManager = MethodsManager::getInstance();

        $this->scoreboardName = $scoreboardName;

        if($lineCount > 16)
        {
            $this->methodsManager->getServer()->getLogger()->critical("You tried to create a scoreboard with more than 16 lines");
        }
        $this->lineCount = $lineCount;

        for ($line = 1; $line <= $lineCount; $line++)
        {

            $this->setLine($line, str_repeat(" ", $line));
        }

        $this->player = $player;
    }

    /**
     * Sends a scoreboard to the player if possible
     *
     * @return void
     */
    public function sendToPlayer() : void
    {
        $name = $this->player->getName();

        if(!$this->methodsManager->isHideList($name))
        {
            $this->methodsManager->removeScoreBoard($this->player, $name);

            $pk = new SetDisplayObjectivePacket();
            $pk->displaySlot = $pk::DISPLAY_SLOT_SIDEBAR;
            $pk->objectiveName = $this->player->getName();
            $pk->displayName = $this->scoreboardName;
            $pk->criteriaName = "dummy";
            $pk->sortOrder = 0;

            $this->player->getNetworkSession()->sendDataPacket($pk);

            $lines = 1;

            foreach ($this->contents as $content)
            {

                $entryes = new ScorePacketEntry();
                $entryes->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
                $entryes->objectiveName = $name;
                $entryes->customName = $content;
                $entryes->score = $lines;
                $entryes->scoreboardId = $this->scoreboardId;

                $pk = new SetScorePacket();
                $pk->type = 0;
                $pk->entries[] = $entryes;
                $this->player->getNetworkSession()->sendDataPacket($pk);

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
            $this->methodsManager->getServer()->getLogger()->warning("You are trying to change line number " . $lineNumber . " even though there are only " . $this->lineCount);

            return;
        }

        $this->contents[$lineNumber] = $content;
    }

}