<?php

namespace Admin\Controller;

use Admin\Form\SettingForm;
use Blog\Entity\Setting;
use Zend\View\Model\ViewModel;


class SettingController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $setting = $em->getRepository('Blog\Entity\Setting')->findOneByState(true);

        if (!$setting) {
            //Create default config if not exist
            $setting = new Setting();
            $setting->setConfigName('Default config');
            $setting->setPagination(5);
            $setting->setBackgroundColor('#ffffff');
            $setting->setNavbarColor('#ffffff');
            $setting->setState(true);
        }

        $settingForm = new SettingForm();
        $settingForm->setData((array) $setting);
        $settingForm->get('submit')->setAttribute('value', 'Modifier');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $settingForm->setData($request->getPost());
            if ($settingForm->isValid()) {

                $setting = $this->getHydrator()->hydrate($settingForm->getData(), $setting);

                //Persist and flush entity Setting
                $em->persist($setting);
                $em->flush();


                $this->getEventManager()->trigger('setting.edit', null, [
                    'user_id' => $this->zfcUserAuthentication()->getIdentity()->getId(),
                    'user_email' => $this->zfcUserAuthentication()->getIdentity()->getEmail(),
                    'config_id' => $setting->getId(),
                    'config_name' => $setting->getConfigName(),
                ]);

                //Add flash message
                $this->flashMessenger()->addMessage('La configuration a bien été changé.');

                //Redirection
                return $this->redirect()->toRoute('admin/setting');
            }
        }

        return new ViewModel([
            'settingForm' => $settingForm
        ]);
    }

}