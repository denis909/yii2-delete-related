<?php

namespace denis909\yii;

use yii\db\ActiveRecord;

class DeleteRelationsBehavior extends \yii\base\Behavior
{

    public $relations = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete'
        ];
    }

    public function beforeDelete($event)
    {
        foreach($this->relations as $name)
        {
            $value = $this->owner->{$name};

            if (is_array($value))
            {
                foreach($value as $related)
                {
                    if (!$related->delete())
                    {
                        $event->isValid = false;
                    }
                }
            }
            else
            {
                if ($value)
                {
                    if (!$value->delete())
                    {
                        $event->isValid = false;
                    }
                }
            }
        }
    }

}
