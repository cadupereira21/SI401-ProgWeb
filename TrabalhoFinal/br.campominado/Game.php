<?php

class Game
{
    private int $id;
    private int $userId;
    private string $date;
    private string $gameMode;
    private array $grid;
    private int $numBombs;
    private int $time;
    private bool $isAWin;

    public function __construct(int $id, int $userId, string $date, string $gameMode, array $grid, int $numBombs, int $time, bool $isAWin)
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
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getDate(): string
    {
        return $this->date;
    }
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getGameMode(): string
    {
        return $this->gameMode;
    }
    public function setGameMode(string $gameMode): void
    {
        $this->gameMode = $gameMode;
    }

    public function getGrid(): array
    {
        return $this->grid;
    }
    public function setGrid(array $grid): void
    {
        $this->grid = $grid;
    }

    public function getNumBombs(): int
    {
        return $this->numBombs;
    }
    public function setNumBombs(int $numBombs): void
    {
        $this->numBombs = $numBombs;
    }

    public function getTime(): int
    {
        return $this->time;
    }
    public function setTime(int $time): void
    {
        $this->time = $time;
    }

    public function isAWin(): bool
    {
        return $this->isAWin;
    }
    public function setIsAWin(bool $isAWin): void
    {
        $this->isAWin = $isAWin;
    }




}