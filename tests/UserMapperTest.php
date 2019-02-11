<?php

use PHPUnit\Framework\TestCase;
use Marketing\factories\DBFactory;

class UserMapperTest extends TestCase
{
    protected $userMapper;
    protected $mockedFactory;

    public function setUp() :void
    {
        $mockedFactory = $this->createMock(DBFactory::class);
        var_dump($mockedAdapter);
        // die;
        $this->userMapper = new \Marketing\mapper\UserMapper($mockedAdapter);

        $this->mockedAdapter
            ->method('create')
            ->willReturn($rateInfo);
    }

    public function testFindBy()
    {

    }
}