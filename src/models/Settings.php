<?php

namespace carlcs\pushovernotificationchannel\models;

use craft\base\Model;

class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $token;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['token', 'string'],
        ];
    }
}
