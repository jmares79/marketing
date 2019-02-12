<?php

use PHPUnit\Framework\TestCase;
use Marketing\adapters\MySql;
use Marketing\entities\User;

/**
 * Class to test UserMapper class
 */
class UserMapperTest extends TestCase
{
    protected $userMapper;

    public function setUp() :void
    {
        $this->mockedAdapter = $this->createMock(MySql::class);
        $this->userMapper = new \Marketing\mapper\UserMapper($this->mockedAdapter);
    }

    /**
     * Tests finding by a non existing user
     */
    public function testFindByNonExistingUser()
    {
        $mockedUser = $this->createMock(User::class);
        $mockedUser->method('getUsername')->willReturn('unknownUser');

        $this->assertSame(null, $this->userMapper->findBy($mockedUser));
    }

    /**
     * Tests finding by an existing user
     */
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
     * Tests saving a different type of users mocked with the help of the dataprovider
     * 
     * @dataProvider adapterResponsesProvider
     */
    public function testSaveUser($fetchReturn, $saveMethodType, $saveMethodReturn, $toArray)
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

    /**
     * Data provider
     */
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
