<?php

use PHPUnit\Framework\TestCase;
use Marketing\factories\DBFactory;
use Marketing\adapters\MySql;
use Marketing\entities\User;

class UserMapperTest extends TestCase
{
    protected $userMapper;
    // protected $mockedFactory;

    public function setUp() :void
    {
        // $this->mockedFactory = $this->createMock(DBFactory::class);
        $this->mockedAdapter = $this->createMock(MySql::class);
        // $this->mockedUser = $this->createMock(User::class);

        $this->userMapper = new \Marketing\mapper\UserMapper($this->mockedAdapter);
    }

    public function testFindByNonExistingUser()
    {
        $mockedUser = $this->createMock(User::class);
        $mockedUser->method('getUsername')->willReturn('unknownUser');

        // $res = $this->userMapper->findBy($mockedUser);

        $this->assertSame(null, $this->userMapper->findBy($mockedUser));
    }

    public function testFindByExistingUser()
    {
        $mockedUser = $this->createMock(User::class);
        $this->mockedAdapter
            ->method('fetch')
            ->willReturn(
                array(
                    'id' => 1,
                    'username' => 'existingUser',
                    'password' => 'somepassword',
                    'created' => '0000-00-00'
                )
            );
        
        $res = $this->userMapper->findBy($mockedUser);

        $this->assertIsArray($res);
        $this->assertArrayHasKey('id', $res);
        $this->assertArrayHasKey('username', $res);
        $this->assertArrayHasKey('password', $res);
        $this->assertArrayHasKey('created', $res);
    }

    /**
     * @dataProvider adapterResponsesProvider
     */
    public function testSaveNewValidUser($fetchReturn, $saveMethodType, $saveMethodReturn, $toArray)
    {
        $this->mockedAdapter
            ->method('fetch')
            ->willReturn($fetchReturn);

        $this->mockedAdapter
            ->method($saveMethodType)
            ->willReturn($saveMethodReturn);            

        $mockedUser = $this->createMock(User::class);

        $mockedUser
            ->method('toArray')
            ->willReturn($toArray);

        $mockedUser->method('getUsername')->willReturn('newUser');

        $res = $this->userMapper->save($mockedUser);

        $this->assertTrue($res);
    }
    

    // /**
    //  * @expectedException \InvalidArgumentException
    //  */
    // public function testSaveInvalidUser()
    // {

    // }

    public function adapterResponsesProvider()
    {
        return array(
            array(
                false, 
                "insert", 
                true, 
                array('id' => 1, 'username' => 'newUser', 'password' => 'somepassword', 'created' => '0000-00-00')
            ),
            array(
                array('id' => 1, 'username' => 'existingUser', 'password' => 'somepassword', 'created' => '0000-00-00'),
                "update", 
                true,
                array('id' => 1, 'username' => 'newUser', 'password' => 'somepassword', 'created' => '0000-00-00')
            )
        );
    }
}