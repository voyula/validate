<?php
/**
 * voyula/Validate - PHP library for data format validation.
 *
 * @link https://github.com/voyula/validate
 * @author voyula <https://github.com/voyula>
 * @copyright (c) 2018, voyula
 * @license https://github.com/voyula/validate/blob/1.0.1/LICENSE.md MIT License
 */
namespace Voyula\Validate;

/**
 * Class Validate
 *
 * @package Voyula\Validate
 */
class Validator extends Validation
{
    /**
     * @var string
     */
    private $lang;
    /**
     * @var array
     */
    private $labels = [];
    /**
     * @var array
     */
    private $rules = [];
    /**
     * @var array
     */
    private $errors = [];

    /**
     * Validator constructor.
     *
     * @param string $lang
     */
    public function __construct(string $lang = 'tr')
    {
        $this->lang          = require __DIR__ . '/lang/' . $lang . '/' . $lang . '.php';
        $this->lang['roles'] = require __DIR__ . '/lang/' . $lang . '/' . $lang . '_roles.php';
    }

    /**
     * @param string $mode
     *
     * @return void
     */
    public function clean(string $mode): void
    {
        switch ($mode) {
            case 'errors':
                $this->errors = [];
                break;
            case 'rules':
                $this->labels = [];
                $this->rules  = [];
        }
    }

    /**
     * @param string $name
     * @param string $label
     * @param string $rules
     *
     * @return void
     */
    public function addRule(string $name, string $label, string $rules): void
    {
        $this->labels[$name] = $label;
        $this->rules[$name]  = $rules;
    }

    /**
     * @param array $check
     *
     * @return void
     */
    public function addRules(array $check): void
    {
        foreach ($check as $item) {
            $this->labels[$item[0]] = $item[1];
            $this->rules[$item[0]]  = $item[2];
        }
    }

    /**
     * @return void
     */
    private function setError(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function run(array $data): bool
    {
        $this->clean('errors');
        foreach ($this->labels as $name => $label) {
            $this->check($data, $name, $label, explode('|', $this->rules[$name]));
        }
        $this->clean('rules');

        return ! $this->errors();
    }

    /**
     * @param array $data
     * @param string $name
     * @param string $label
     * @param array $rules
     *
     * @return void
     */
    private function check(array $data, string $name, string $label, array $rules): void
    {
        if (! isset($data[$name])) {
            $this->setError(sprintf($this->lang['req'], $label));
            return;
        }

        foreach ($rules as $row) {
            $param = explode(':', $row);
            $func  = $param[0];
            array_shift($param);

            switch ($func) {
                case 'same':
                    if ($data[$name] !== $data[$param[0]]) {
                        $this->setError(sprintf($this->lang['same'], $label, $this->labels[$param[0]]));
                        return;
                    }
                    break;
                case 'role':
                    if (! $this->{$param[0]}($data[$name])) {
                        $this->setError(sprintf($this->lang['roles'][$param[0]], $label));
                        return;
                    }
                    break;
                default:
                    if (method_exists($this, $func)) {
                        if (! call_user_func_array([$this, $func], array_merge([$data[$name]], $param))) {
                            $this->setError(
                                call_user_func_array('sprintf', array_merge([
                                    $this->lang[$func],
                                    $label
                                ], $param))
                            );
                            return;
                        }
                    }
            }
        }
    }
}
