<?php declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\CloneAbleUser;

final class CloneAbleUserTest extends TestCase
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

        $user2 = $user1->clone();

        $user1->setName('John');

        $this->assertSame($user1->getName(), 'John');
        $this->assertSame($user2->getName(), 'Rick'); // changing the name of the user1 DOES NOT CHANGE the name of the user2
    }

    public function testUserCloningWithFriends(): void
    {
        $user1 = $this->createUserWithFriend();
        $this->assertSame($user1->getName(), 'Rick');

        $user2 = $user1->clone();

        $this->assertSame($user1->getFriendName(0), 'Martin');
        $this->assertSame($user2->getFriendName(0), 'Martin');

        $user1->setFriendName(0, 'Colin');

        $this->assertSame($user1->getFriendName(0), 'Colin');
        $this->assertSame($user2->getFriendName(0), 'Martin'); // changing the name of the user1 DOES NOT CHANGE the name of the user2
    }

    public function testUserCloningWithCrossReferenceFriends2(): void
    {
        $rick = new CloneAbleUser(1, 'Rick', []);
        $martin = new CloneAbleUser(2, 'Martin', []);

        // Make cross refs
        $rick->addFriend($martin);
        $martin->addFriend($rick);

        $this->assertSame($rick->getFriendName(0), 'Martin');
        $this->assertSame($martin->getFriendName(0), 'Rick');

        $anotherRick = $rick->clone();

        $this->assertSame($anotherRick->getFriendName(0), 'Martin');

        $rick->setFriendName(0, 'John');
        $this->assertSame($anotherRick->getFriendName(0), 'Martin'); // changing the name of the user1 DOES NOT CHANGE the name of the user2
    }


    public function testUserCloningWithCrossReferenceFriends3(): void
    {
        $rick = new CloneAbleUser(1, 'Rick', []);
        $martin = new CloneAbleUser(2, 'Martin', []);
        $colin = new CloneAbleUser(3, 'Colin', []);

        // Make cross refs
        $rick->addFriend($martin);
        $martin->addFriend($colin);
        $colin->addFriend($rick);

        $this->assertSame($rick->getFriendName(0), 'Martin');
        $this->assertSame($martin->getFriendName(0), 'Colin');
        $this->assertSame($colin->getFriendName(0), 'Rick');

        $anotherRick = $rick->clone();

        $this->assertSame($anotherRick->getFriendName(0), 'Martin');

        $rick->setFriendName(0, 'John');
        $this->assertSame($anotherRick->getFriendName(0), 'Martin'); // changing the name of the user1 DOES NOT CHANGE the name of the user2
    }

    private function createUserWithoutFriends(): CloneAbleUser
    {
        return new CloneAbleUser(1, 'Rick', []);
    }

    private function createUserWithFriend(): CloneAbleUser
    {
        return new CloneAbleUser(1, 'Rick',
            [
                new CloneAbleUser(2, 'Martin', [])
            ]);
    }
}