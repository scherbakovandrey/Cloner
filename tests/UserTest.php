<?php declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\User;

final class UserTest extends TestCase
{
    public function testAssignmentUserWithoutFriends(): void
    {
        $user1 = $this->createUserWithoutFriends();
        $this->assertSame($user1->getName(), 'Rick');

        $user2 = $user1;

        $user1->setName('John');

        $this->assertSame($user1->getName(), 'John');
        $this->assertSame($user2->getName(), 'John'); // changing the name of the user1 changes the name of the user2
    }

    public function testUserCloningWithoutFriends(): void
    {
        $user1 = $this->createUserWithoutFriends();
        $this->assertSame($user1->getName(), 'Rick');

        $user2 = clone $user1;

        $user1->setName('John');

        $this->assertSame($user1->getName(), 'John');
        $this->assertSame($user2->getName(), 'Rick'); // changing the name of the user1 DOES NOT change the name of the user2
    }

    public function testUserCloningWithFriends(): void
    {
        $user1 = $this->createUserWithFriend();
        $this->assertSame($user1->getName(), 'Rick');

        $user2 = clone $user1;

        $this->assertSame($user1->getFriendName(0), 'Martin');
        $this->assertSame($user2->getFriendName(0), 'Martin');

        $user1->setFriendName(0, 'Colin');

        $this->assertSame($user1->getFriendName(0), 'Colin');
        $this->assertSame($user2->getFriendName(0), 'Colin'); // changing the name of the user1 CHANGES the name of the user2
    }

    private function createUserWithoutFriends(): User
    {
        return new User(1, 'Rick', []);
    }

    private function createUserWithFriend(): User
    {
        return new User(1, 'Rick',
            [
                new User(2, 'Martin', [])
            ]);
    }
}