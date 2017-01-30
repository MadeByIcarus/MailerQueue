<?php
/**
 * Created by PhpStorm.
 * User: pavelgajdos
 * Date: 30.01.17
 * Time: 14:15
 */

namespace Icarus\QueueMailer\DI;


use Kdyby\Doctrine\DI\IEntityProvider;
use Nette\DI\CompilerExtension;

class QueueMailerExtension extends CompilerExtension implements IEntityProvider
{

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