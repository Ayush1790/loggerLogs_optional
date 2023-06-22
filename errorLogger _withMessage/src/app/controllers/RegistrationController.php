<?php

use Phalcon\Mvc\Controller;
use Phalcon\Escaper;
use logs\Error\ErrorLogger;
class RegistrationController extends Controller
{
    public function indexAction()
    {
        $this->response->redirect("registration/register");
    }
    public function registerAction()
    {
        //redirect to view
    }
    public function processAction()
    {
        $logger=new ErrorLogger();
        $count = 0;
        $escaper = new Escaper();
        $user = new Users();
        $nameBeforeSanitize = $this->request->getPost('name');
        $emailBeforeSanitize = $this->request->getPost('email');
        $pswdBeforeSanitize = $this->request->getPost('pswd');
        $data = [
            'name' => $escaper->escapeHtml($nameBeforeSanitize),
            'email' => $escaper->escapeHtml($emailBeforeSanitize),
            'pswd' => $escaper->escapeHtml($pswdBeforeSanitize)
        ];
        if ($nameBeforeSanitize != $data['name']) {
            $logger->errorMsg("eror",'$nameBeforeSanitize . "<=injected name"');
            $count++;
        }
        if ($emailBeforeSanitize != $data['email']) {
           $logger->errorMsg("error",'$emailBeforeSanitize . "<=injected email"');
            $count++;
        }

        $user->assign(
            $data,
            ['name', 'email', 'pswd']
        );
        $success = $user->save();
        if ($count > 0) {
            echo "Code Injected";
        } elseif ($success) {
            echo "Registration Succesful";
        }
    }
}
