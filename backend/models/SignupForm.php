<?php
namespace backend\models;

use yii\base\Model;
use common\models\AdminUser;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $nickname;
    public $profile;
    public $password_repeat;


    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'nickname' => Yii::t('app', 'Nickname'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'profile' => Yii::t('app', 'Profile'),
            'password_repeat' => Yii::t('app', 'Password Repeat'),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\AdminUser', 'message' => \Yii::t('app','This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\AdminUser', 'message' => \Yii::t('app','This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致！'],
//            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message'=>'两次输入的密码不一致'],
            ['nickname', 'required'],
            ['nickname', 'string', 'max' => 128],
            ['profile', 'string'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return AdminUser|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return $this->errors;
        }
        
        $user = new AdminUser();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->nickname = $this->email;
        $user->profile = $this->profile;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->password = '*';
//        var_dump($user->id);exit(0);
        return $user->save() ? $user : null;
    }
}
