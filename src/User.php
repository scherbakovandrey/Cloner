<?php declare(strict_types=1);

namespace App;

use function PHPUnit\Framework\throwException;
use App\Exception\UserFriendIndexException;

class User
{
    protected int $id;
    protected string $name;
    protected array $friends = [];

    public function __construct(int $id, string $name, array $friends)
    {
        $this->id = $id;
        $this->name = $name;
        $this->friends = $friends;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFriends(): array
    {
        return $this->friends;
    }

    /**
     * @throws UserFriendIndexException
     */
    public function setFriendName(int $index, string $name): void
    {
        if (isset($this->friends[$index]))
        {
            $this->friends[$index]->setName($name);

            return;
        }
        throw new UserFriendIndexException('This user doesn\'t have a friend with the index: ' . $index);
    }

    /**
     * @throws UserFriendIndexException
     */
    public function getFriend(int $index): self
    {
        if (isset($this->friends[$index]))
        {
            return $this->friends[$index];
        }
        throw new UserFriendIndexException('This user doesn\'t have a friend with the index: ' . $index);
    }

    /**
     * @throws UserFriendIndexException
     */
    public function getFriendName(int $index): string
    {
        if (isset($this->friends[$index]))
        {
            return $this->friends[$index]->getName();
        }
        throw new UserFriendIndexException('This user doesn\'t have a friend with the index: ' . $index);
    }
}