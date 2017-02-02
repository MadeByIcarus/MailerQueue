<?php
/**
 * Created by PhpStorm.
 * User: pavelgajdos
 * Date: 30.01.17
 * Time: 14:15
 */

namespace Icarus\QueueMailer\DI;


use Icarus\QueueMailer\QueueMailer;
use Kdyby\Doctrine\DI\IEntityProvider;
use Nette\DI\CompilerExtension;
use Nette\InvalidArgumentException;
use Nette\Utils\Validators;


class QueueMailerExtension extends CompilerExtension implements IEntityProvider
{
    private $defaults = [
        'defaultLanguage' => 'en',
        'defaultSender' => ''
    ];

    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);
        Validators::assertField($config, 'defaultSender', 'string');

        if (!Validators::isEmail($config['defaultSender'])) {
            throw new InvalidArgumentException("Invalid Email address '".$config['defaultSender']."'");
        }

        $this->getContainerBuilder()->addDefinition($this->prefix("QueueMailer"))
            ->setClass(QueueMailer::class, [$config['defaultSender'], $config['defaultLanguage']]);
    }

    /**
     * Returns associative array of Namespace => mapping definition
     *
     * @return array
     */
    function getEntityMappings()
    {
        return [
            'Icarus\QueueMailer' => __DIR__ . '/../Model/'
        ];
    }
}