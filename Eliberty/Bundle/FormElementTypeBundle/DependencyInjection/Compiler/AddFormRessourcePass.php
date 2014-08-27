<?php

/*
 * This file is part of theRedpillBundle package.
 *
 * (c)philippe vesin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eliberty\Bundle\FormElementTypeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Add a new twig.form.resources
 * 
 * @author Philippe vesin 
 */
class AddFormRessourcePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');

        foreach (array('div', 'jquery', 'stylesheet') as $template) {
            $resources[] = 'FormBundle:Form:' . $template . '_layout.html.twig';
        }

        $container->setParameter('twig.form.resources', $resources);
    }
}
