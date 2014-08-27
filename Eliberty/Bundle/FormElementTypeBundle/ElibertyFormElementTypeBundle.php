<?php

namespace Eliberty\Bundle\FormElementTypeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Eliberty\Bundle\FormElementTypeBundle\DependencyInjection\Compiler\AddFormRessourcePass;

class ElibertyFormElementTypeBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AddFormRessourcePass());
    }
}
