<?php

class AdminController extends BaseAdminController
{
    
    public function actionIndex(){
        
        $this->render('index');
    }
    
    public function actionSites(){
        $error = '';
        if(query('inputTitle') && query('inputFolder') && query('inputDomains')){
            if(!query('inputTitle')){
                $error .= '- Введите заголовок сайта<br />';
            }
            if(!query('inputFolder')){
                $error .= '- Введите папку сайта<br />';
            }else if(!preg_match('/[a-zA-Z-_]/',query('inputFolder'))){
                $error .= '- Папка сайта должна содержать только буквы латинского алфавита<br />';
            }
            if(!query('inputDomains')){
                $error .= '- Введите домены<br />';
            // TODO: Доделать для русских доменов
            }else if(!preg_match('/[a-zA-Z-_\.,]/',query('inputDomains'))){
                $error .= '- Домены должны содержать только буквы латинского алфавита<br />';
            }
            if(!is_dir(app()->getBasePath().DS.'views'.DS.'sites')){
                if(!is_writable(app()->getBasePath().DS.'views'.DS)){
                    $error .= '- Нет прав запси в папку '.app()->getBasePath().DS.'views'.DS.'<br />';
                }else{
                    mkdir(app()->getBasePath().DS.'views'.DS.'sites');
                }
            }
            if(is_dir(app()->getBasePath().DS.'views'.DS.'sites/'.strtolower(query('inputFolder')))){
                $error .= '- Указанная папка с сайтом уже существует. Удалите ее или укажите другую<br />';
            }else if(!is_writable(app()->getBasePath().DS.'views'.DS.'sites'.DS)){
                $error .= '- Нет прав доступа на запись в папку сайтов ('.app()->getBasePath().DS.'views'.DS.'sites'.DS.')<br />';
            }
            if($isSite = SITES::model()->findByAttributes(array('folder'=>query('inputFolder')))){
                $error .= '- Указанная папка привязана к сайту <a href="'.app()->createUrl('admin/siteEdit/id/'.$isSite->id).'">'.$isSite->title.'</a><br />';
            }
            if($error){
                $_GET['new'] = 1;
            }else{
                $title = query('inputTitle');
                $folder = strtolower(query('inputFolder'));
                $domains = strtolower(query('inputDomains'));
                $inputTemplateHeader = query('inputTemplateHeader');
                $inputTemplateFooter = query('inputTemplateFooter');
                // Создаем папку сайта
                mkdir(app()->getBasePath().DS.'views'.DS.'sites'.DS.$folder);
                // Создаем шаблон сайта
                file_put_contents(app()->getBasePath().DS.'views'.DS.'sites'.DS.$folder.DS.'template.php',$inputTemplateHeader."\n".'<?php echo $content; ?>'."\n".$inputTemplateFooter);
                file_put_contents(app()->getBasePath().DS.'views'.DS.'sites'.DS.$folder.DS.'index.php','Hello world!');
                $site = new SITES();
                $site->title = $title;
                $site->folder = $folder;
                $site->save();
                if(substr_count($domains,',') > 0){
                    foreach(explode(',',$domains) as $dom){
                        $domain = new DOMAINS();
                        $domain->domain_name = $dom;
                        $domain->site_id = $site->id;
                        $domain->save();
                    }
                }else{
                    $domain = new DOMAINS();
                    $domain->domain_name = $domains;
                    $domain->site_id = $site->id;
                    $domain->save();
                }
                $this->redirect(app()->createUrl('admin/siteEdit/id/'.$site->id));
            }
        }      
        $sites = SITES::model()->findAll();
        $this->render('sites', array(
            'error' => $error,
            'sites' => $sites,
        ));
    }
    
    public function actionSiteEdit(){
        $sites = SITES::model()->findAll();
        $this->render('siteEdit', array(
            'sites' => $sites,
        ));
    }
    
    public function actionDomains(){
        $sites = SITES::model()->findAll();
        $domains = DOMAINS::model()->findAll();
        $this->render('domains', array(
            'domains' => $domains,
            'sites' => $sites,
        ));
    }
    
    public function actionAjaxSaveDomain(){
        $result = new stdClass();
        try {
            if(query('isdelete')){
                $deleteId = (int) query('isdelete');
                DOMAINS::model()->deleteByPk($deleteId);
                $result->deleted = 1;
            }else if(query('isnew')){
                $domainName = strtolower(query('domainName'));
                $siteId = (int) query('siteId');
                if(!$domainName || !preg_match('/[a-z\.-_]/',$domainName))
                    e('Domain is not correct');
                if(!$siteId)
                    e('Site is not correct');
                $domain = new DOMAINS();
                $domain->domain_name = $domainName; 
                $domain->site_id = $siteId;
                $domain->save();
                $result->added = $domain->id;
            }else{
                $id = (int) query('id');
                $domainName = strtolower(query('domainName'));
                $siteId = (int) query('siteId');
                if(!$domainName || !preg_match('/[a-z\.-_]/',$domainName))
                    e('Domain is not correct');
                if(!$siteId)
                    e('Site is not correct');
                if(!$domain = DOMAINS::model()->findByPk($id))
                    e('Domain not founded');
                $domain->domain_name = $domainName; 
                $domain->site_id = $siteId;
                $domain->save();
                $result->saved = 1;
            }
        } catch (Exception $e) {
            $result->error = $e->getMessage();
        }
        echo CJSON::encode($result);
    }
    
    public function actionLogin(){
        if(!Yii::app()->getUser()->isGuest) {
            $this->redirect(app()->createUrl('admin'));
        }
        $user = new USERS();
        if(query('username') && query('password')){
            $user->scenario = 'login';
            $user->password = query('password');
            $user->username = query('username');
            if($user->validate()) {
              $this->redirect(app()->createUrl('admin'));
            }
        }
        $this->render('login', array(
            'user' => $user,
        ));
    }
    
    public function actionLogout(){
        app()->user->logout();
        $this->redirect(app()->createUrl('admin/login'));
    }
        
}

?>