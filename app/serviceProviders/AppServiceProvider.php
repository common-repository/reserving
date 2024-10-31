<?php 

declare(strict_types=1);

namespace Reserving\serviceProviders;

use Reserving_Packages\DI\ServiceProvider\AbstractServiceProvider;
use Reserving_Packages\DI\ServiceProvider\BootableServiceProviderInterface;
use Reserving\backend\settings\Settings_Controller as Settings_Controller;
use Reserving\serviceProviders\App\Notice as Reserving_Notice;

class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * The provides method is a way to let the container
     * know that a service is provided by this service
     * provider. Every service that is registered via
     * this service provider must have an alias added
     * to this array or it will be ignored.
     */
    public function provides(string $id): bool
    {
        $services = [
            'app_key',
            Settings_Controller::class,
            Reserving_Notice::class,
        ];
        
        return in_array($id, $services);
    }

    /**
     * In much the same way, this method has access to the container
     * itself and can interact with it however you wish, the difference
     * is that the boot method is invoked as soon as you register
     * the service provider with the container meaning that everything
     * in this method is eagerly loaded.
     *
     * If you wish to apply inflectors or register further service providers
     * from this one, it must be from a bootable service provider like
     * this one, otherwise they will be ignored.
     */
    public function boot(): void
    {
        
    }

    /**
     * The register method is where you define services
     * in the same way you would directly with the container.
     * A convenience getter for the container is provided, you
     * can invoke any of the methods you would when defining
     * services directly, but remember, any alias added to the
     * container here, when passed to the `provides` nethod
     * must return true, or it will be ignored by the container.
     */
    public function register(): void
    {
     
        $this->getContainer()->add('app_key', 'reserving');
        $this->getContainer()->add(Settings_Controller::class);
        $this->getContainer()->add(\Reserving\serviceProviders\App\Notice::class);

    }
}
