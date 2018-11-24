<?php

namespace App;

use FOS\HttpCache\SymfonyCache\CacheInvalidation;
use FOS\HttpCache\SymfonyCache\CustomTtlListener;
use FOS\HttpCache\SymfonyCache\DebugListener;
use FOS\HttpCache\SymfonyCache\EventDispatchingHttpCache;
use FOS\HttpCache\SymfonyCache\PurgeListener;
use FOS\HttpCache\SymfonyCache\PurgeTagsListener;
use FOS\HttpCache\SymfonyCache\RefreshListener;
use FOS\HttpCache\SymfonyCache\UserContextListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\StoreInterface;
use Symfony\Component\HttpKernel\HttpCache\SurrogateInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Toflar\Psr6HttpCacheStore\Psr6Store;

class CacheKernel extends HttpCache implements CacheInvalidation
{
    use EventDispatchingHttpCache;

    /**
     * Overwrite constructor to register event listeners for FOSHttpCache.
     *
     * @param HttpKernelInterface $kernel
     * @param StoreInterface $store
     * @param SurrogateInterface|null $surrogate
     * @param array $options
     */
    public function __construct(
        HttpKernelInterface $kernel,
        SurrogateInterface $surrogate = null,
        array $options = []
    ) {
        $store = new Psr6Store([
            'cache_directory' => $kernel->getCacheDir(),
            'cache_tags_header' => 'X-Cache-Tags',
        ]);

        parent::__construct($kernel, $store, $surrogate, $options);

        $this->addSubscriber(new CustomTtlListener());
        $this->addSubscriber(new PurgeListener());
        $this->addSubscriber(new RefreshListener());
        $this->addSubscriber(new PurgeTagsListener());
        $this->addSubscriber(new UserContextListener());
        if (isset($options['debug']) && $options['debug']) {
            $this->addSubscriber(new DebugListener());
        }
    }

    /**
     * Made public to allow event listeners to do refresh operations.
     *
     * {@inheritDoc}
     */
    public function fetch(Request $request, $catch = false)
    {
        return parent::fetch($request, $catch);
    }
}