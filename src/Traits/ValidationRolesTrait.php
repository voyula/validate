<?php
/**
 * voyula/validate - PHP library for data format validation.
 *
 * @link https://github.com/voyula/validate
 * @author voyula <https://github.com/voyula>
 * @copyright (c) 2018, voyula
 * @license https://github.com/voyula/validate/blob/1.0.1/LICENSE.md MIT License
 */
namespace Voyula\Validate;

/**
 * Trait ValidationRolesTrait
 * @package Voyula\Validate
 */
trait ValidationRolesTrait
{
    /**
     * @param string $string
     *
     * @return bool
     */
    public function username(string $string): bool
    {
        return (bool) preg_match('/^[a-z0-9_.]+$/i', $string);
    }
}
