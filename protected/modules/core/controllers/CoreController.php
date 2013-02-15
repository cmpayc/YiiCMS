<?php

class CoreController extends Controller
{
	public $layout='column1';

	/**
	 * Declares class-based actions.
	 */
	public function actionIndex(){
            $this->render('Index');
        }
}
