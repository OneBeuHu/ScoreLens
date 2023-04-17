<?php

namespace onebeuhu\scorelens\utils;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

abstract class Utils
{

	/**
	 * @param Player $player
	 * @param string $soundName
	 *
	 * @return void
	 */
	public static function sendSoundToPlayer(Player $player, string $soundName) : void
	{
		$position = $player->getPosition();

		$player->getNetworkSession()->sendDataPacket(PlaySoundPacket::create($soundName, $position->getX(), $position->getY(), $position->getZ(), 1, 1));
	}
}