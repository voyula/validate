<?php
/**
 * voyula/validate - PHP library for data format validation.
 *
 * @link https://github.com/voyula/validate
 * @author voyula <https://github.com/voyula>
 * @copyright (c) 2018, voyula
 * @license https://github.com/voyula/validate/blob/1.0.1/LICENSE.md MIT License
 */
namespace Voyula\Validate\Tests;

use PHPUnit\Framework\TestCase;
use Voyula\Validate\Validator;

/**
 * Class ValidatorTest
 *
 * @package Voyula\Validate\Tests
 */
class ValidatorTest extends TestCase
{
    /**
     * @var \Voyula\Validate\Validator
     */
    private $validator;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->validator = new Validator;
    }

    /**
     * @return void
     */
    public function testTrueValidator(): void
    {
        $this->validator->addRules([
            ['username', 'Username', 'role:username|minLen:3|maxLen:15'],
            ['email', 'Email', 'email|maxLen:100'],
            ['password', 'Password', 'minLen:4|maxLen:25'],
            ['password_again', 'Password Again', 'same:password']
        ]);

        $this->validator->addRule('postal_code', 'Postal Code', 'digit|len:5');
        $this->validator->addRule('item_count', 'Item Count', 'numeric|minNum:5|maxNum:1000');

        $data = [
            'username' => 'panther',
            'email' => 'panther@mail.com',
            'password' => 'panther123',
            'password_again' => 'panther123',
            'postal_code' => '43945',
            'item_count' => '572'
        ];

        $this->assertTrue($this->validator->run($data));
        $this->assertEmpty($this->validator->getErrors());
    }

    /**
     * @return void
     */
    public function testFalseValidator(): void
    {
        $this->validator->addRules([
            ['username', 'Username', 'role:username|minLen:3|maxLen:15'],
            ['email', 'Email', 'email|maxLen:100'],
            ['password', 'Password', 'minLen:4|maxLen:25'],
            ['password_again', 'Password Again', 'same:password']
        ]);

        $this->validator->addRule('postal_code', 'Postal Code', 'digit|len:5');
        $this->validator->addRule('item_count', 'Item Count', 'numeric|minNum:5|maxNum:1000');

        $data = [
            'username' => 'pa',
            'email' => 'panther@-ail.com',
            'password' => 'pan',
            'password_again' => 'panther123',
            'postal_code' => '439456',
            'item_count' => '1001'
        ];

        $this->assertFalse($this->validator->run($data));
        $this->assertNotEmpty($this->validator->getErrors());
    }
}
