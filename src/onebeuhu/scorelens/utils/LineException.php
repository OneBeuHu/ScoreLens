<?php

namespace onebeuhu\scorelens\utils;

class LineException extends \Exception
{
    public static function wrap(string $player) : self{
        return new self("Attempt to set the content in a line exceeding the maximum for the player " . $player);
    }
}