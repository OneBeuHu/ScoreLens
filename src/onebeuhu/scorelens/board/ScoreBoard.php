<?php

namespace onebeuhu\scorelens\board;

use onebeuhu\scorelens\displayer\ScoreboardDisplayer;
use onebeuhu\scorelens\utils\LineException;
use pocketmine\player\Player;

class ScoreBoard
{

    protected CONST MAX_LINE_COUNT = 16;

    /**  @var string */
    private string $name = "ScoreBoard";
    private string $objectiveName = "";
    private string $boardScene = "";

    /**  @var array */
    private array $contents = [];

    /** @var bool  */
    private bool $isHidden = true;

    /**
     * @param Player $player
     * @param int $unicalBoardId
     * @param array $contents
     */
    protected function __construct(private Player $player, private int $unicalBoardId, array $contents, string $scene)
    {
        if(BoardManager::hasBoard($this->player))
        {
            BoardManager::removeBoard($this->player);
        }

        BoardManager::addBoard($this);
        $this->objectiveName = $this->player->getName();
        $this->boardScene = $scene;

        if(array_key_last($contents) > self::MAX_LINE_COUNT)
        {
            throw LineException::wrap($this->player->getName());
        }

        for ($line = 1; $line <= array_key_last($contents); $line++)
        {
            isset($contents[$line]) ? ($this->contents[$line] = $contents[$line]) : ($this->contents[$line] = str_repeat(' ', $line));
        }
    }

    /**
     * @param Player $player
     * @return static
     */
    public static function create(Player $player, array $contents = [], string $scene = "default") : ?self
    {
       if($player->isConnected())
       {
           return new ScoreBoard($player, BoardManager::nextUnicalId(), $contents, $scene);
       }

       return null;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getUnicalBoardId() : int
    {
        return $this->unicalBoardId;
    }

    /**
     * @param int $line
     * @param string $content
     * @return void
     */
    public function setLine(int $line, string $content) : void
    {
        if($line > self::MAX_LINE_COUNT)
        {
            throw LineException::wrap($this->player->getName());
        }

        if(!$this->player->isConnected())
        {
            $this->remove();
            return;
        }

        ScoreboardDisplayer::handleLine($this, $line, $content);
        $this->contents[$line] = $content;
    }

    /**
     * @return array
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    /**
     * @return void
     */
    public function hide() : void
    {
        $this->isHidden = true;
        ScoreboardDisplayer::handleHide($this);
    }

    /**
     * @return void
     */
    public function show() : void
    {
        $this->isHidden = false;
        ScoreboardDisplayer::handleShow($this);
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->isHidden;
    }

    /**
     * @return string
     */
    public function getObjectiveName() : string
    {
        return $this->objectiveName;
    }

    /**
     * @return void
     */
    public function remove() : void
    {
        BoardManager::removeBoard($this->player);
        ScoreboardDisplayer::handleRemove($this);
    }

    /**
     * @param string $scene
     * @return void
     */
    public function setScene(string $scene) : void
    {
        $this->boardScene = $scene;
    }

    /**
     * @return string
     */
    public function getScene() : string
    {
        return $this->boardScene;
    }
}
