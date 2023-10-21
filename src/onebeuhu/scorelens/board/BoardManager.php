<?php

namespace onebeuhu\scorelens\board;

use pocketmine\player\Player;

class BoardManager
{
    /** @var $scoreboards ScoreBoard[]  */
    private static array $scoreboards = [];

    /** @var int */
    private static int $unicalId = 0;

    /**
     * @param Player $player
     * @return bool
     */
    public static function hasBoard(Player $player) : bool
    {
        return isset(self::$scoreboards[strtolower($player->getName())]);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function removeBoard(Player $player) : void
    {
        unset(self::$scoreboards[strtolower($player->getName())]);
    }

    /**
     * @param ScoreBoard $scoreBaord
     * @return void
     */
    public static function addBoard(ScoreBoard $scoreBaord) : void
    {
       self::$scoreboards[strtolower($scoreBaord->getPlayer()->getName())] = $scoreBaord;
    }

    /**
     * @param Player $player
     * @return ScoreBoard
     */
    public static function getBoard(Player $player) : ScoreBoard
    {
        return self::$scoreboards[strtolower($player->getName())];
    }

    /**
     * @return ScoreBoard[]
     */
    public static function getBoards() : array
    {
        return self::$scoreboards;
    }

    /**
     * @return int
     */
    public static function nextUnicalId() : int
    {
        return self::$unicalId++;
    }
}