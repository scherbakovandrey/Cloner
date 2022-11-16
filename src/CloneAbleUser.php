<?php declare(strict_types=1);

namespace App;

class CloneAbleUser extends User implements CloneAbleInterface
{
    private array $hashMap = [];

    public function clone(): self
    {
        $this->hashMap = [];

        return $this->recursiveClone();
    }

    private function recursiveClone(): self
    {
        $objHash = spl_object_hash($this);

        if (isset($this->hashMap[$objHash])) {
            return $this->hashMap[$objHash];
        }

        $this->hashMap[$objHash] = $this;

        $obj = clone $this;

        $obj->friends = [];
        foreach ($this->friends as $friend)
        {
            /** @var $friend CloneAbleUser */
            $obj->friends[] = $friend->recursiveClone();
        }

        return $obj;
    }

    public function addFriend(CloneAbleUser $user): void
    {
        $this->friends[] = $user;
    }
}