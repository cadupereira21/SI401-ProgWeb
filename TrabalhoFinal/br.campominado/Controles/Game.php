<?php

class Game
{
    private int $id;
    private int $userId;
    private string $date;
    private string $gameMode;
    private string $grid;
    private int $numBombs;
    private string $time;
    private bool $isAWin;

    //region Constructor, Getters e Setters
    public function __construct(int $id, int $userId, string $date, string $gameMode, string $grid, int $numBombs, string $time, bool $isAWin)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->date = $date;
        $this->gameMode = $gameMode;
        $this->grid = $grid;
        $this->numBombs = $numBombs;
        $this->time = $time;
        $this->isAWin = $isAWin;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getGameMode(): string
    {
        return $this->gameMode;
    }

    public function getGrid(): string
    {
        return $this->grid;
    }

    public function getNumBombs(): int
    {
        return $this->numBombs;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function isAWin(): bool
    {
        return $this->isAWin;
    }
    //endregion

    /**
     * @throws ErrorException
     */
    public static function BuildGame(array $elem): Game {
        if(count($elem) != 8) throw new ErrorException("O Parâmetro passado não possui 8 elementos!");

        return new Game($elem["gameId"], $elem["game_userId"], $elem["gameDate"], $elem["gameMode"], $elem["grid"], $elem["numBombs"], $elem["gameTime"], $elem["isAWin"]);
    }
}?>