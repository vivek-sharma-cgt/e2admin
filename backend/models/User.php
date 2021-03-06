<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


/**
* This is the model class for table "user".
*
* @property integer $id
* @property string $username
* @property string $auth_key
* @property string $password_hash
* @property string $password_reset_token
* @property string $email
* @property integer $status
* @property string $image
* @property integer $created_at
* @property integer $updated_at
*/
class User extends \yii\db\ActiveRecord
{
    public $file;
    public $auth_role;
    public $password;
    
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'user';
    }

    public function behaviors(){
		return [
				[
			    'class' => TimestampBehavior::className(),
			    'createdAtAttribute' => 'created_at',
			    'updatedAtAttribute' => 'updated_at',
			    'value' => new Expression('UNIX_TIMESTAMP()'),
			],
		];
	}
    
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['firstname','lastname','username', 'email','role'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['firstname','lastname','username', 'password_hash', 'password_reset_token', 'email','image'], 'string', 'max' => 255],
            ['email','email'],
            ['username', 'unique'],
            ['email', 'unique'],
            [['password'] ,'required','when' => function($model,$attribute){
                return !empty($model->id) ? false: true;
            }, 'whenClient' => "function (attribute, value) {  if(jQuery('form#user_form').find('button:submit').text() == 'Create'){
                    return true;
                }
                else{
                    return false;
                }
            }"],
            ['file', 'file','extensions' => ['png', 'jpg', 'jpeg']],
            [['auth_role','password'],'safe']

        ];
    }
    
    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
        'id' => 'ID',
        'username' => 'Username',
        'email' => 'Email',
        'status' => 'Status',
        'image' => 'Image',
        'auth_role' => 'Role',
        ];
    }

    
    /**
    * Upload Profile photo
    * @return file name if true otherwise false
    */
    public function upload(){
        if($this->validate()){
            $this->file->saveAs('uploads/user/'.$this->id.'.'.$this->file->extension);
            return true;
        }
        else {
            return false;
        }
    }
    
       /**
    * Finds a User
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @return User  model
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function getUser($id){
        if(($model = User::findOne($id)) !== null){
            return $model;
        }
        else{
            throw new NotFoundHttpException;
        }
    }

    public function assignRolesAndSave($user){
        //initialize auth manager
        $auth  = Yii::$app->authManager;
        
        //revoke role if assigned
        if(!empty($user->id)){
            $assignedRole = User::findOne($user->id)->role;
            if(!empty($assignedRole)){
                $assignedRole = $auth->getRole($assignedRole);
                $auth->revoke($assignedRole,$user->id);
            }
        }

        //assign new user role
        $role = $auth->getRole($user->role);
        $assignments = $auth->getAssignment($user->role,$user->id);
        if(!empty($role) && empty($assignments)){
            $auth->assign($role,$user->id);
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssigments()
    {
        return $this->hasMany(AuthAssignment::className(), ['id' => 'user_id']);
    }
}