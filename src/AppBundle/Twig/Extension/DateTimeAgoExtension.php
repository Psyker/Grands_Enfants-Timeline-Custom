<?php

namespace AppBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Twig_Extension;
use Twig_Filter_Method;

use \Smirik\PHPDateTimeAgo\DateTimeAgo as DateTimeAgo;

class DateTimeAgoExtension extends \Twig_Extension
{

    protected $container;

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            'ago' => new Twig_Filter_Method($this, 'ago')
        );
    }

    public function ago($date)
    {
        /** Add your custom logic depending on locale */
//        $locale = $this->container->get('request')->getLocale();
//        if ($locale == 'ru') {
//            $datetime_ago = new DateTimeAgo(new \Smirik\PHPDateTimeAgo\TextTranslator\RussianTextTranslator());
//            $datetime_ago->setFormat('d.m.Y');
//        }
        $datetime_ago = new DateTimeAgo();
        $datetime_ago->setFormat('d/m/Y');
        return $datetime_ago->get($date);
    }

    public function getName()
    {
        return 'ago.twig.extension';
    }

}