<?php

namespace SupportBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class DateTimeToStringTransformer implements DataTransformerInterface
{

    public function __construct()
    {   
    }

    /**
     * @param \DateTime|null $datetime
     * @return string
     */
    public function transform($datetime)
    {
        if (null === $datetime) {
            return '';
        }       
        return $datetime->format('Y-m-d H:i:s');
    }

    /**
     * @param  string $datetimeString
     * @return \DateTime
     */
    public function reverseTransform($datetimeString)
    {
        $datetime = new \DateTime($datetimeString);
        return $datetime;
    }
} 