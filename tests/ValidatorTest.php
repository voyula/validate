<?php
/**
 * voyula/validator - PHP library for data format validation.
 *
 * @link https://github.com/voyula/Validator
 * @author voyula <https://github.com/voyula>
 * @copyright (c) 2018, voyula
 * @license https://github.com/voyula/Validator/blob/1.0.1/LICENSE.md MIT License
 */
namespace Voyula\Validator\Tests;

use PHPUnit\Framework\TestCase;
use Voyula\Validator\Validator;

/**
 * Class ValidatorTest
 * @package Voyula\Validator\Tests
 */
class ValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testTrueValidator(): void
    {
        $validator = new Validator;

        $validator->addRules([
            ['username', 'Username', 'role:username|minLen:3|maxLen:15'],
            ['email', 'Email', 'email|maxLen:100'],
            ['password', 'Password', 'minLen:4|maxLen:25'],
            ['password_again', 'Password Again', 'same:password']
        ]);

        $validator->addRule('postal_code', 'Postal Code', 'digit|len:5');
        $validator->addRule('item_count', 'Item Count', 'numeric|minNum:5|maxNum:1000');

        $data = [
            'username' => 'panther',
            'email' => 'panther@mail.com',
            'password' => 'panther123',
            'password_again' => 'panther123',
            'postal_code' => '43945',
            'item_count' => '572'
        ];

        $this->assertTrue($validator->run($data));
        $this->assertEmpty($validator->errors);
    }

    /**
     * @return void
     */
    public function testFalseValidator(): void
    {
        $validator = new Validator;

        $validator->addRules([
            ['username', 'Username', 'role:username|minLen:3|maxLen:15'],
            ['email', 'Email', 'email|maxLen:100'],
            ['password', 'Password', 'minLen:4|maxLen:25'],
            ['password_again', 'Password Again', 'same:password']
        ]);

        $validator->addRule('postal_code', 'Postal Code', 'digit|len:5');
        $validator->addRule('item_count', 'Item Count', 'numeric|minNum:5|maxNum:1000');

        $data = [
            'username' => 'pa',
            'email' => 'panther@-ail.com',
            'password' => 'pan',
            'password_again' => 'panther123',
            'postal_code' => '439456',
            'item_count' => '1001'
        ];

        $this->assertFalse($validator->run($data));
        $this->assertNotEmpty($validator->errors);
    }
}
