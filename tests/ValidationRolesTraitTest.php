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

/**
 * Class ValidationRolesTraitTest
 *
 * @package Voyula\Validate\Tests
 */
class ValidationRolesTraitTest extends TestCase
{
    use \Voyula\Validate\Traits\ValidationRolesTrait;

    /**
     * @return void
     */
    public function testUsername(): void
    {
        $tests = [
            ''      => false,
            ' '     => false,
            '*'     => false,
            'hello' => true,
            '???'   => false,
            '+++++' => false,
            'f_o.r' => true,
            'h%i'   => false,
            '_.___' => true,
            'g._'   => true,
            '.A.6_' => true,
            'a=2l'  => false,
            'a3._.' => true,
            'bY_r'  => true,
            'Hh.i'  => true,
            't.g_i' => true
        ];

        foreach ($tests as $content => $bool) {
            $this->assertEquals($this->username($content), $bool);
        }
    }
}
