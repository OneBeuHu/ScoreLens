<?php

namespace onebeuhu\scorelens\manager;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class MethodManager
{

	use SingletonTrait;

	/**
	 * @var array
	 */
    protected array $hideList = [];

    /**
     * @param string $name
     * @return bool
     */
    public function isHideList(string $name) : bool
    {
        return isset($this->hideList[$name]);
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
	 * @param string $name
	 * @return void
	 */
	public function addInHideList(string $name) : void
	{
		$this->hideList[$name] = $name;
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
