<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class ProviderContainer.
 */
class ProviderContainer
{
    const PROVIDER_CONTAINER = 'ss.provider.container';

    /**
     * @var ArrayCollection|ProviderInterface[]
     */
    protected $providers;

    /**
     * ProviderContainer constructor.
     */
    public function __construct()
    {
        $this->providers = new ArrayCollection();
    }

    /**
     * @param Collection $providers
     */
    public function setProviders(Collection $providers)
    {
        $this->providers = $providers;
    }

    /**
     * @return ArrayCollection|ProviderInterface[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param string $name
     *
     * @return ProviderInterface|null
     */
    public function getProvider($name)
    {
        return $this->providers->get($name);
    }

    /**
     * @param ProviderInterface $provider
     *
     * @return $this
     */
    public function addProvider(ProviderInterface $provider)
    {
        if (!$this->providers->contains($provider)) {
            $this->providers->set($provider->getName(), $provider);
        }

        return $this;
    }

    /**
     * @param ProviderInterface $provider
     *
     * @return $this
     */
    public function removeProvider(ProviderInterface $provider)
    {
        $this->providers->removeElement($provider);

        return $this;
    }
}
