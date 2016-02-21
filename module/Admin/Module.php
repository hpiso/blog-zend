<?php

namespace Admin;

use Zend\Db\Adapter\Adapter;
use Zend\Log\Logger;
use Zend\Log\Writer\Db;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    protected $logger;

    public function __construct()
    {
        $db = new Adapter([
            'driver' => 'Pdo_Mysql',
            'host' => '127.0.0.1',
            'username' => 'root',
            'dbname' => 'zendblog'
        ]);

        $logger = new Logger();

        $mapping = [
            'timestamp' => 'date',
            'priority' => 'priority',
            'message' => 'description'
        ];

        $writer = new Db($db, 'logs', $mapping, '-');
        $logger->addWriter($writer);

        $this->logger = $logger;
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //Load Admin layout
        $sharedEventManager->attach(__NAMESPACE__, 'dispatch', function ($e)
        {
            $e->getTarget()->layout('admin/layout');
        });

        //Load Admin layout
        $sharedEventManager->attach('ZfcUser', 'dispatch', function ($e)
        {
            $e->getTarget()->layout('admin/layout-login');
        });

        //Check Authentification
        $t = $e->getTarget();
        $t->getEventManager()->attach(
            $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy')
        );

        //Évènements des articles
        $sharedEventManager->attach('Admin\Controller\ArticleController', 'article.add', function ($e)
        {
            $this->logger->info('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') created article "' . $e->getParam('article_title') . '" (id:' . $e->getParam('article_id') . ').');
        });
        $sharedEventManager->attach('Admin\Controller\ArticleController', 'article.edit', function ($e)
        {
            $this->logger->info('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') edited article "' . $e->getParam('article_title') . '" (id:' . $e->getParam('article_id') . ').');
        });
        $sharedEventManager->attach('Admin\Controller\ArticleController', 'article.delete', function ($e)
        {
            $this->logger->info('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') deleted article "' . $e->getParam('article_title') . '" (id:' . $e->getParam('article_id') . ').');
        });

        // Évènements pour les catégories
        $sharedEventManager->attach('Admin\Controller\CategoryController', 'category.add', function ($e)
        {
            $this->logger->info('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') created category "' . $e->getParam('category_name') . '" (id:' . $e->getParam('category_id') . ').');
        });
        $sharedEventManager->attach('Admin\Controller\CategoryController', 'category.edit', function ($e)
        {
            $this->logger->warn('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') edited article "' . $e->getParam('category_name') . '" (id:' . $e->getParam('category_id') . ').');
        });
        $sharedEventManager->attach('Admin\Controller\CategoryController', 'category.delete', function ($e)
        {
            $this->logger->info('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') deleted article "' . $e->getParam('category_name') . '" (id:' . $e->getParam('category_id') . ').');
        });

        //Évènements des commentaires
        $sharedEventManager->attach('Admin\Controller\CommentController', 'comment.add', function ($e)
        {
            $this->logger->info($e->getParam('user_email') . ' wrote a comment (id:' . $e->getParam('comment_id') . ') on article "' . $e->getParam('article_title') . '" (id:' . $e->getParam('article_id') . ').');
        });
        $sharedEventManager->attach('Admin\Controller\CommentController', 'comment.delete', function ($e)
        {
            $this->logger->warn('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') deleted comment (id:' . $e->getParam('comment_id') . ') on article "' . $e->getParam('article_title') . '" (id:' . $e->getParam('article_id') . ').');
        });
        $sharedEventManager->attach('Admin\Controller\CommentController', 'comment.approve', function ($e)
        {
            $this->logger->info('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') approved comment (id:' . $e->getParam('comment_id') . ') on article "' . $e->getParam('article_title') . '" (id:' . $e->getParam('article_id') . ').');
        });
        $sharedEventManager->attach('Admin\Controller\CommentController', 'comment.reject', function ($e)
        {
            $this->logger->warn('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') rejected comment (id:' . $e->getParam('comment_id') . ') on article "' . $e->getParam('article_title') . '" (id:' . $e->getParam('article_id') . ').');
        });

        //Évènements des options
        $sharedEventManager->attach('Admin\Controller\SettingController', 'setting.add', function ($e)
        {
            $this->logger->info('User ' . $e->getParam('user_email') . ' (id:' . $e->getParam('user_id') . ') added a configuration setting"' . $e->getParam('config_name') . '" (id:' . $e->getParam('config_id') . ').');
        });


        // Events liés à la connexion / deconnexion
        $zfcAuthEvents = $e->getApplication()->getServiceManager()->get('ZfcUser\Authentication\Adapter\AdapterChain')->getEventManager();

        $zfcAuthEvents->attach('authenticate.pre', function ($e)
        {
            $this->logger->notice('Someone accessed the login form from IP ' . $_SERVER['REMOTE_ADDR']);
        });
        $zfcAuthEvents->attach('authenticate.success', function ($e)
        {
            $this->logger->notice('User successfully login the application from' . $_SERVER['REMOTE_ADDR']);
        });
        $zfcAuthEvents->attach('authenticate.fail', function ($e)
        {
            $this->logger->warn('Someone failed to login from ' . $_SERVER['REMOTE_ADDR'] . ' with credentials ');
        });
        $zfcAuthEvents->attach('logout', function ($e)
        {
            $this->logger->notice('User logged out from ' . $_SERVER['REMOTE_ADDR']);
        });

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}