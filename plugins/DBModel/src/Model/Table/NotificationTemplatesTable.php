<?php
namespace DBModel\Model\Table;

use DBModel\Model\Entity\NotificationTemplate;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Table\AppTable;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;

/**
 * NotificationTemplates Model
 *
 * @property \Cake\ORM\Association\HasMany $DelEnvs
 * @property \Cake\ORM\Association\HasMany $DeliverySignoffs
 * @property \Cake\ORM\Association\HasMany $NotificationTemplateLangs
 */
class NotificationTemplatesTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->Activities = TableRegistry::get('DBModel.Activities');
        $this->Usrs = TableRegistry::get('DBModel.Usrs');
        $this->Prefs = TableRegistry::get('DBModel.Prefs');

        $this->table('notification_templates');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('DelEnvs', [
            'foreignKey' => 'notification_template_id'
        ]);
        $this->hasMany('DeliverySignoffs', [
            'foreignKey' => 'notification_template_id'
        ]);
        $this->hasMany('NotificationTemplateLangs', [
            'foreignKey' => 'notification_template_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));
        return $rules;
    }

     /**
     * Sends a notification
     *
     * @param array $recipients recipients of the letter
     * @param string $name name of the template
     * @param array $attachment_info attachments info
     * @param array $propertyArray set of properties
     * @return bool
     */
     
    public function sendNotification(array $recipients, $name = null,  $attachment_info = null , $propertyArray = null )
    {

        if(!$name) {
            return ['errors' => 'No name supplied for NotificationTemplate'];
        }

        $data = $this->get($this->field('id', ['name'=>$name] ),  ['contain' => ['NotificationTemplateLangs']]);
  
        $path = [];

        if(in_array($attachment_info['include_activity_log'], ["Full Logs", "Action Only"]) && $attachment_info['activity_id'] && $attachment_info['process_id']) {
            $path = $this->Activities->getArtTree($attachment_info['activity_id'], $attachment_info['process_id'], $attachment_info['include_activity_log']);
        }
        

        $email = new Email();
        
        Email::configTransport('gmail', [
            'host' => $this->getSysPref('mail_smtp_server','127.0.0.1') === 'localhost' ? '127.0.0.1' : $this->getSysPref('mail_smtp_server','127.0.0.1'),
            'port' => $this->getSysPref('mail_smtp_port','25'),
            'username' => $this->getSysPref('mail_smtp_authuser','') === '' ? null : $this->getSysPref('mail_smtp_authuser',''),
            'password' => $this->getSysPref('mail_smtp_authpass','') === '' ? null : $this->getSysPref('mail_smtp_authpass',''),
            'client' => $this->getSysPref('mail_smtp_helo','') === '' ? null : $this->getSysPref('mail_smtp_helo',''),
            'className' => 'Smtp',
        ]);
 
        $email->transport('gmail');

        if(!empty($path)) {
            $email->attachments($path);
        }

        $email->from([$this->getSysPref('mail_from','BRPD Admin <root@yourhost.com>') => $this->getSysPref('mail_from','BRPD Admin <root@yourhost.com>') ]);
        $validLangs = [];
        $alternativeDefault = '';
        foreach($data->notification_template_langs as $lang) {
            $validLangs[$lang->lang] = $lang;
            if(!$alternativeDefault) {
                $alternativeDefault = $lang->lang;
            }
        }
        // Gen List of Users...
        $toUsers = [];
        $defaultLang = $this->getSysPref('lang', 'eng');
        if(!isset($alternativeDefault)) {
            $defaultLang = $altnativeDefault;
        }

        if(is_array($recipients)) {
            foreach($recipients as $userId) {
                // if its already an email, don't ask pref for email...
                if(preg_match('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/',$userId) > 0) {
                    $toUsers[$defaultLang][] = $userId;
                }
                else {
                    $userName = $userId;
                    $userId = $this->Usrs->field('id', ['username' => $userName ]);
                    $userEmail = $this->Prefs->getPreference('email_address', $userId, '');
                    $userLang = $this->Prefs->getPreference('lang', $userId, 'eng');
                    if(!isset($validLangs[$userLang])) {
                        $userLang = $defaultLang;
                    }
                    // Cursary check to see if it looks like a valid email address?
                    if(!$userEmail) {
                        $defaultDomain = $this->Prefs->getPreference('default_domain', $userId, '');
                        if($defaultDomain)
                            $userEmail = $userName . '@' . $defaultDomain;
                        else
                            $userEmail = $userName;
                    }
                    if($userEmail) {
                        $toUsers[$userLang][] = $userEmail;
                    }
                }
            }
        }
        else {
            // assume its a correct list.
            $toUsers = $recipients;
        }
 
        // $hasSend = false;
        $errors = '';
        foreach($toUsers as $toLang => $toList) {
            if(count($toList) < 1){
                continue;
            }
   
            // Get the Properties Block to process...
            $subject = $validLangs[$toLang]->subject;
            $body = $validLangs[$toLang]->body;
            if(!empty($propertyArray)) {
                $this->expandPropertiesText($propertyArray,$subject);
                $this->expandPropertiesText($propertyArray,$body);
            }            
            try{
                $email->to($toList);
                $email->subject($subject);
                $email->emailFormat('both');
                $email->send($body);
            }catch(\Exception $e){
                 return ['errors' => $e->getMessage()];
            }
        }
        // If files were generated lets remove them from a files system
        if(!empty($path)){
            $this->Activities->destroyActionLogs($path);
        }
        return true;
       
    }

       /**
     * Resolvance of the properties
     *
     * @param array $propertyArray set of properties
     * @param array $text text 
     * @return bool
     */

    //TODO: Test for infinite expansion - should be ok, but just incase.
    //      That's as in A=$B, B=$C, C=$A; and A=$B B=$A    
    // Calling NOTE - call as expandEnvText('Env Name',<StringVariable>) or expandEnvText(EnvObject,<StringVariable>).
    // StringVariable will be replaced with its expanded value, and the function will return true/false depending if there
    // were any ${} vars that 'Must' be replaced/exist.
    // 
    public function expandPropertiesText($propertyArray,&$text) {
        if(empty($propertyArray)) {
            return true;
        }
        // Iterate through the text replace as appropriate...
        $pieces = preg_split('/(\$[{[(])(.*?)([})\]])/',$text,0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        $closeMode = "";
        $returnType = true;
        $text = "";
        foreach($pieces as $piece) {
            switch($piece) {
                case '${':
                    $closeMode='}';
                    break;
                case '$(':
                    $closeMode=')';
                    break;
                case '$[':
                    $closeMode=']';
                    break;
                case '}':
                case ')':
                case ']':
                    $closeMode='';
                    break;
                default:
                    if($closeMode == '}') {
                        // Strict replace.
                        if($newpiece = $this->getPropertyVal($propertyArray,$piece)) {
                            $piece = $newpiece;
                        } else {
                            $returnType = false;
                        }
                    }
                    if($closeMode == ')') {
                        if($newpiece = $this->getPropertyVal($propertyArray, $piece)) 
                            $piece = $newpiece;
                        else
                            $piece = '';
                    }
                    if($closeMode == ']') {
                        if($newpiece = $this->getPropertyVal($propertyArray, $piece)) 
                            $piece = $newpiece;
                    }
                    $text .= $piece;
            }
        }
        return($returnType);
    }

     /**
     * get the value of a property
     *
     * @param array $propertyArray set of properties
     * @param array $property property name 
     * @return bool | string
     */

    public function getPropertyVal($propertyArray, $property = '') {
        if (!isset($propertyArray))
            return false;
        if (array_key_exists($property, $propertyArray)) {
            return $propertyArray[$property];
        }
        return false;
    }
}
