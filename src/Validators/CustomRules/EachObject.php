<?php

declare(strict_types=1);

namespace Shucream0117\PhalconLib\Validators\CustomRules;

use Phalcon\Validation;
use Shucream0117\PhalconLib\Validators\AbstractValidator;
use Shucream0117\PhalconLib\Validators\ValidationResult;
use Shucream0117\PhalconLib\Validators\ValidationRuleSet;

/*
 * [
 *   "params" => [ // バリデーション対象の連想配列のリスト
 *     ["hoge"=>"fuga", "piyo"=>1]
 *   ],
 *   "rule_sets" => [
 *     new ValidationRuleSet('name', [
 *       new PresenceOf($this->optionCancelOnFail()),
 *       new StringType($this->optionCancelOnFail()),
 *     ]),
 *   ]
 * ]
 */

class EachObject extends Validation\Validator\Callback
{
    protected $template = 'Field :field has invalid properties';

    public function __construct(array $options = [])
    {
        $options['callback'] = function (): bool {
            /** @var ValidationRuleSet[] $ruleSetList */
            $ruleSetList = $this->getOption('rule_sets') ?: [];
            $params = $this->getOption('params') ?: [];

            $validator = new class extends AbstractValidator {
                public function validate(array $params, array $rules): ValidationResult
                {
                    return parent::validate($params, $rules);
                }
            };
            $result = $validator->validate($params, $ruleSetList);
            return empty($result->getErrors());
        };
        parent::__construct($options);
    }
}
