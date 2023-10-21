<?php

namespace onebeuhu\scorelens\displayer;

use onebeuhu\scorelens\board\ScoreBoard;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;

class ScoreboardDisplayer
{

    /**
     * @var array
     */
    protected static array $cache = [];

    /**
     * @param ScoreBoard $scoreBaord
     * @return void
     */
    public static function handleShow(ScoreBoard $scoreBaord) : void
    {
        $packets[] = SetDisplayObjectivePacket::create(
        SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR,
        $scoreBaord->getObjectiveName(),
        $scoreBaord->getName(),
        "dummy",
        0
        );

        $entries = [];
        foreach ($scoreBaord->getContents() as $line => $content)
        {

            $scoreEntries = new ScorePacketEntry();
            $scoreEntries->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
            $scoreEntries->objectiveName = $scoreBaord->getObjectiveName();
            $scoreEntries->customName = $content;
            $scoreEntries->score = $line;
            $scoreEntries->scoreboardId = $line;

            $entries[$line] = $scoreEntries;
        }

        $packets[] = SetScorePacket::create(
            SetScorePacket::TYPE_CHANGE,
            $entries
        );

        self::$cache[$scoreBaord->getUnicalBoardId()] = $entries;


        $session = $scoreBaord->getPlayer()->getNetworkSession();
        $session->getBroadcaster()->broadcastPackets([$session], $packets);
    }

    /**
     * @param ScoreBoard $scoreBaord
     * @param int $line
     * @param string $content
     * @return void
     */
    public static function handleLine(ScoreBoard $scoreBaord, int $line, string $content) : void
    {
        if($scoreBaord->isHidden())
        {
            return;
        }

        if(empty(self::$cache[$scoreBaord->getUnicalBoardId()]))
        {
            return;
        }

        //$scoreBaord->getPlayer()->getNetworkSession()->sendDataPacket(SetScorePacket::create(SetScorePacket::TYPE_REMOVE, [self::$cache[$scoreBaord->getUnicalBoardId()][$line]]));

        $entries = new ScorePacketEntry();
        $entries->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
        $entries->objectiveName = $scoreBaord->getObjectiveName();
        $entries->customName = $content;
        $entries->score = $line;
        $entries->scoreboardId = $line;

        self::$cache[$scoreBaord->getUnicalBoardId()][$line] = $entries;


        $scoreBaord->getPlayer()->getNetworkSession()->sendDataPacket(SetScorePacket::create(SetScorePacket::TYPE_CHANGE, [$entries]));
    }

    /**
     * @param ScoreBoard $scoreBoard
     * @return void
     */
    public static function handleRemove(ScoreBoard $scoreBoard) : void
    {
        unset(self::$cache[$scoreBoard->getUnicalBoardId()]);
    }

    /**
     * @param ScoreBoard $scoreBoard
     * @return void
     */
    public static function handleHide(ScoreBoard $scoreBoard) : void
    {
        $scoreBoard->getPlayer()->getNetworkSession()->sendDataPacket(RemoveObjectivePacket::create($scoreBoard->getObjectiveName()));
    }

}