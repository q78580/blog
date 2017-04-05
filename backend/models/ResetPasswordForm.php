<?php
namespace backend\models;

use yii\base\Model;
use common\models\AdminUser;
use Yii;

/**
 * Signup form
 */
class ResetPasswordForm extends Model
{

    public $password;
    public $password_repeat;


    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Password Repeat'),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致！'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return AdminUser|null the saved model or null if saving fails
     */
    public function resetPassword($id)
    {

        if (!$this->validate()) {
            return $this->errors;
        }

        $user = AdminUser::findOne($id);

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->removePasswordResetToken();

        return $user->save() ? true : false;
    }
}
