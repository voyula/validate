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
 * Class Validation
 * @package Voyula\Validate
 */
class Validation
{
    use Traits\ValidationRolesTrait;

    /**
     * @param string $string
     * @param int $len
     *
     * @return bool
     */
    public function len(string $string, int $len): bool
    {
        return mb_strlen($string, 'UTF-8') === $len;
    }

    /**
     * @param string $string
     * @param int $min_len
     *
     * @return bool
     */
    public function minLen(string $string, int $min_len): bool
    {
        return mb_strlen($string, 'UTF-8') >= $min_len;
    }

    /**
     * @param string $string
     * @param int $max_len
     *
     * @return bool
     */
    public function maxLen(string $string, int $max_len): bool
    {
        return mb_strlen($string, 'UTF-8') <= $max_len;
    }

    /**
     * @param int $num
     * @param int $min_num
     *
     * @return bool
     */
    public function minNum(int $num, int $min_num): bool
    {
        return $num >= $min_num;
    }

    /**
     * @param int $num
     * @param int $max_num
     *
     * @return bool
     */
    public function maxNum(int $num, int $max_num): bool
    {
        return $num <= $max_num;
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public function numeric(string $string): bool
    {
        return is_numeric($string);
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public function email(string $string): bool
    {
        return (bool) filter_var($string, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public function digit(string $string): bool
    {
        return ctype_digit($string);
    }
}
