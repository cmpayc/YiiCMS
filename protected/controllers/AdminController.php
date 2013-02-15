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
            if(is_dir(app()->getBasePath().'/views/sites/'.strtolower(query('inputFolder')))){
                $error .= '- Указанная папка с сайтом уже существует. Удалите ее или укажите другую';
            }else if(!is_writable(app()->getBasePath().'/views/sites/')){
                $error .= '- Нет прав доступа на запись в папку сайтов';
            }
            if($isSite = SITES::model()->findByAttributes(array('folder'=>query('inputFolder')))){
                $error .= '- Указанная папка привязана к сайту <a href="'.app()->createUrl('admin/siteEdit/id/'.$isSite->id).'">'.$isSite->title.'"</a>';
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
                mkdir(app()->getBasePath().'/views/sites/'.$folder);
                // Создаем шаблон сайта
                file_put_contents(app()->getBasePath().'/views/sites/'.$folder.'/template.php',$inputTemplateHeader."\n".'<?php echo $content; ?>'."\n".$inputTemplateFooter);
                file_put_contents(app()->getBasePath().'/views/sites/'.$folder.'/index.php','Hello world!');
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