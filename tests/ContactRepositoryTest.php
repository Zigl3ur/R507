<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class ContactRepositoryTest extends TestCase
{
    public function testMessage(): void
    {
        $messageRepo = $this->createMock(\App\Repository\ContactRepository::class);
        $messageRepo->expects($this->once())
            ->method('search')
            ->willReturn([
                new \App\Entity\Contact("test", "test", "test"),
            ]);
        $this->assertEquals([new \App\Entity\Contact("test", "test", "test")], $messageRepo->search('test'));
    }

    public function testMessageCount(): void
    {
        $messageRepo = $this->createMock(\App\Repository\ContactRepository::class);
        $messageRepo->expects($this->once())
            ->method('search')
            ->willReturn([
                new \App\Entity\Contact("test1", "test1", "test1"),
                new \App\Entity\Contact("test2", "test2", "test2"),
                new \App\Entity\Contact("test3", "test3", "test3"),
            ]);
        $this->assertCount(3, $messageRepo->search('test'));
    }
}
