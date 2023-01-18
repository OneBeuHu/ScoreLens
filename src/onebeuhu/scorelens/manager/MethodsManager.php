<?php

namespace onebeuhu\scorelens\manager;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\player\Player;
use pocketmine\Server;

class MethodsManager
{

    /** @VAR $playerList array */
    protected array $playerList = [];

    /** @VAR $hideList array */
    protected array $hideList = [];

    /**
     * @var Server|null
     */
    protected ?Server $server = null;

    /**
     * @var MethodsManager|null
     */
    protected static ?MethodsManager $methodsmanager = null;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;

        self::$methodsmanager = $this;
    }

    /**
     * @return Server
     */
    public function getServer() : Server
    {
        return $this->server;
    }

    /**
     * @return MethodsManager
     */
    public static function getInstance() : MethodsManager
    {
        return self::$methodsmanager;
    }

    /**
     * Responsible for displaying/hiding the tablet
     *
     * @param Player $player
     * @return void
     */
    public function changeScoreboardStatus(Player $player) : void
    {
        $name = $player->getName();

        if($this->isHideList($name))
        {
            $this->unsetHideList($name);

            $player->sendMessage("§cYou returned the scoreboard to hide it, write the same command again.");
            $this->sendSoundToPlayer($player, "note.bassattack");
        }
        else
        {
            $this->removeScoreBoard($player, $name);

            $this->hideList[$name] = $name;

            $player->sendMessage("§aYou have hidden the ScoreBoard, to get it back, write the same command again.");
            $this->sendSoundToPlayer($player, "random.orb");
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isHideList(string $name) : bool
    {
        return isset($this->hideList[$name]);
    }

    /**
     * @param Player $player
     * @param string $soundName
     * @return void
     */
    protected function sendSoundToPlayer(Player $player, string $soundName) : void
    {
        $position = $player->getPosition();

        $player->getNetworkSession()->sendDataPacket(PlaySoundPacket::create($soundName, $position->getX(), $position->getY(), $position->getZ(), 1, 1));
    }

    /**
     * @param string $name
     * @return void
     */
    public function unsetHideList(string $name) : void
    {
        unset($this->hideList[$name]);
    }

    /**
     * @param Player $player
     * @param string $objectiveName
     * @return void
     */
    public function removeScoreBoard(Player $player, string $objectiveName) : void
    {
        $player->getNetworkSession()->sendDataPacket(RemoveObjectivePacket::create($objectiveName));
    }
}
