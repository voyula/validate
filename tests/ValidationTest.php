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
use Voyula\Validate\Validation;

/**
 * Class ValidationTest
 * @package Voyula\Validate\Tests
 */
class ValidationTest extends TestCase
{
    /**
     * @var \Voyula\Validate\Validation
     */
    private $validation;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->validation = new Validation;
    }

    /**
     * @return void
     */
    public function testLen(): void
    {
        $assert_true = [
            ''      => 0,
            ' '     => 1,
            'Al'    => 2,
            'Ala'   => 3,
            'Alar'  => 4,
            '3_ş@c' => 5
        ];
        $assert_false = [
            ''      => 1,
            ' '     => 2,
            'Al'    => 3,
            'Ala'   => 4,
            'Alar'  => 5,
            '3_ş@c' => 6,
            '29kdf' => 4
        ];
        foreach ($assert_true as $key => $row) {
            $this->assertTrue($this->validation->len($key, $row));
        }
        foreach ($assert_false as $key => $row) {
            $this->assertFalse($this->validation->len($key, $row));
        }
    }

    /**
     * @return void
     */
    public function testMinLen(): void
    {
        $assert_true = [
            ''     => 0,
            ' '    => 1,
            'Al'   => 2,
            'Ala'  => 3,
            'Alşr' => 3
        ];
        $assert_false = [
            ''    => 1,
            ' '   => 2,
            'Al'  => 3,
            'Aşa' => 4,
            'All' => 5
        ];
        foreach ($assert_true as $key => $row) {
            $this->assertTrue($this->validation->minLen($key, $row));
        }
        foreach ($assert_false as $key => $row) {
            $this->assertFalse($this->validation->minLen($key, $row));
        }
    }

    /**
     * @return void
     */
    public function testMaxLen(): void
    {
        $assert_true = [
            ''    => 0,
            ' '   => 1,
            'Al'  => 2,
            'Ala' => 3,
            'Pş'  => 3
        ];
        $assert_false = [
            ' '     => 0,
            '  '    => 1,
            'Ala'   => 2,
            'Alar'  => 3,
            'Pol4a' => 3
        ];
        foreach ($assert_true as $key => $row) {
            $this->assertTrue($this->validation->maxLen($key, $row));
        }
        foreach ($assert_false as $key => $row) {
            $this->assertFalse($this->validation->maxLen($key, $row));
        }
    }

    /**
     * @return void
     */
    public function testMinNum(): void
    {
        $assert_true = [
            0   => 0,
            -1  => -1,
            1   => 1,
            339 => 339,
            493 => 300,
            928 => 927
        ];
        $assert_false = [
            0    => 1,
            -1   => 0,
            -3   => -2,
            1    => 2,
            339  => 340,
            -493 => 493
        ];
        foreach ($assert_true as $key => $row) {
            $this->assertTrue($this->validation->minNum($key, $row));
        }
        foreach ($assert_false as $key => $row) {
            $this->assertFalse($this->validation->minNum($key, $row));
        }
    }

    /**
     * @return void
     */
    public function testMaxNum(): void
    {
        $assert_true = [
            0   => 0,
            1   => 1,
            -1  => 1,
            -1  => -1,
            339 => 339,
            493 => 500,
            928 => 929
        ];
        $assert_false = [
            0   => -1,
            1   => 0,
            -3  => -10,
            2   => 1,
            339 => 338,
            493 => 0,
            928 => -928
        ];
        foreach ($assert_true as $key => $row) {
            $this->assertTrue($this->validation->maxNum($key, $row));
        }
        foreach ($assert_false as $key => $row) {
            $this->assertFalse($this->validation->maxNum($key, $row));
        }
    }

    /**
     * @return void
     */
    public function testNumeric(): void
    {
        $tests = [
            ''      => false,
            ' '     => false,
            '*'     => false,
            'hello' => false,
            '55'    => true,
            '1e4'   => true,
            '9.1'   => true,
            '-92'   => true,
            '+292'  => true
        ];

        foreach ($tests as $content => $bool) {
            $this->assertEquals($this->validation->numeric($content), $bool);
        }
    }

    /**
     * @return void
     */
    public function testEmail(): void
    {
        $tests = [
            ''              => false,
            ' '             => false,
            '*'             => false,
            'hello'         => false,
            '1111'          => false,
            '0419'          => false,
            '0419120399'    => false,
            '+102923'       => false,
            '-19201'        => false,
            '_.___'         => false,
            'g._'           => false,
            '.A.6_'         => false,
            'a=2l'          => false,
            'a3._.'         => false,
            'bY_r'          => false,
            'Hh.i'          => false,
            'test@mail.com' => true,
            't@m.com'       => true,
            'test@mail.*'   => false,
            'test@-ail.com' => false,
            '**@**.com'     => false
        ];

        foreach ($tests as $content => $bool) {
            $this->assertEquals($this->validation->email($content), $bool);
        }
    }

    /**
     * @return void
     */
    public function testDigit(): void
    {
        $tests = [
            ''           => false,
            ' '          => false,
            '*'          => false,
            'hello'      => false,
            '1111'       => true,
            '0419'       => true,
            '0419120399' => true,
            '+102923'    => false,
            '-19201'     => false,
            '_.___'      => false,
            'g._'        => false,
            '.A.6_'      => false,
            'a=2l'       => false,
            'a3._.'      => false,
            'bY_r'       => false,
            'Hh.i'       => false
        ];

        foreach ($tests as $content => $bool) {
            $this->assertEquals($this->validation->digit($content), $bool);
        }
    }
}
