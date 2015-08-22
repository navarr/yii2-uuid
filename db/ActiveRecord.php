<?php

namespace wartron\yii2uuid\db;

use Yii;
/**
 * This is the base-model class for table "part".
 *
 * @property string $id
 * @property string $widget_id
 * @property integer $type
 * @property string $name
 *
 * @property \app\models\Widget $widget
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    public $uuidRelations = []

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields,$expand,$recursive);
        $data['id'] = strtoupper(bin2hex($data['id']));

        foreach($this->uuidRelations as $relationKey)
        {
            if(isset($data[$relationKey]))
                $data[$relationKey] = strtoupper(bin2hex($data[$relationKey]));
        }

        return $data;
    }

}
