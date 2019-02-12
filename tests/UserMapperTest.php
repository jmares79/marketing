<?php

use PHPUnit\Framework\TestCase;
use Marketing\factories\DBFactory;
use Marketing\adapters\MySql;
use Marketing\entities\User;

class UserMapperTest extends TestCase
{
    protected $userMapper;
    protected $mockedFactory
    ;

    public function setUp() :void
    {
        // $this->mockedFactory = $this->createMock(DBFactory::class);
        $this->mockedAdapter = $this->createMock(MySql::class);
        $this->mockedUser = $this->createMock(User::class);

        $this->userMapper = new \Marketing\mapper\UserMapper($this->mockedAdapter);
    }

    public function testFindByNonExistingUser()
    {
        $this->mockedUser->method('getUsername')->willReturn('unknownUser');
        $res1 = $this->userMapper->findBy($this->mockedUser);

        $this->assertSame(null, $this->userMapper->findBy($this->mockedUser));
    }

    public function testFindByExistingUser()
    {
        $this->mockedAdapter->method('fetch')
            ->willReturn(
                array(
                    'id' => 1,
                    'username' => 'existingUser',
                    'password' => 'somepassword',
                    'created' => '0000-00-00'
                )
            );
        
        $res = $this->userMapper->findBy($this->mockedUser);

        $this->assertIsArray($res);
        $this->assertArrayHasKey('id', $res);
        $this->assertArrayHasKey('username', $res);
        $this->assertArrayHasKey('password', $res);
        $this->assertArrayHasKey('created', $res);
    }

    public function testSaveNewValidUser()
    {

    }

    public function testSaveExistingValidUser()
    {

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSaveInvalidUser()
    {

    }
}