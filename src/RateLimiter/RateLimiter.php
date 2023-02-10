<?php 

namespace Pw\RateLimiter;

class RateLimiter
{
    /**
     * RateLimiterFactory
     */
    private $rateLimiterFactory = null;

    /**
     * Class constructor
     *
     * @param $rateLimiterFactory
     */
    public function __construct($rateLimiterFactory = null)
    {
        if ($rateLimiterFactory) {
            $this->rateLimiterFactory = $rateLimiterFactory;
        }
    }
    /**
     * @return boolean
     */
    public function isConsumeRateLimiter()
    {
        if (!$this->rateLimiterFactory) {
            return false;
        }
        $limiter = $this->rateLimiterFactory->create(
            $_SERVER['REMOTE_ADDR']
        );
        if (false === $limiter->consume()->isAccepted()) {
            //Trop de demandes;
            return true;
        }
        return false;
    }
}