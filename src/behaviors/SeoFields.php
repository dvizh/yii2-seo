<?php
namespace dvizh\seo\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;
use dvizh\seo\models\Seo;

class SeoFields extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'updateFields',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateFields',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteFields',
        ];
    }

	public function getSeoClassName()
	{
		$model = explode('\\', $this->owner->className());
		
		return end($model);
	}
	
    public function updateFields($event)
    {
        if(isset(Yii::$app->request) &&  method_exists(Yii::$app->request, 'post')) {
            $post = Yii::$app->request->post();
            
            if (!$model = Seo::findOne(['item_id' => $this->owner->id, 'modelName' => $this->getSeoClassName()])) {
                $model = new Seo;
            }
            
            $post['Seo']['item_id'] = $this->owner->id;
            
            $model->load($post);
            $model->save();
        }
    }
    
    public function deleteFields($event)
    {
        if($this->owner->seo) {
            $this->owner->seo->delete();
        }
        
        return true;
    }
    
    public function getSeo()
    {
        if($model = Seo::find()->where(['item_id' => $this->owner->id, 'modelName' => $this->getSeoClassName()])->one()) {
            return $model;
        } else {
            return new Seo;
        }
    }
}
