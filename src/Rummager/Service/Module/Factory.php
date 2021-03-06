<?php

declare(strict_types=1);

namespace Rummager\Service\Module;

use Rummager\Service\ModuleRepositoryInterface;
use Rummager\Service\ServiceProviderInterface;

class Factory
{
    /** @var ModuleRepositoryInterface */
    private $repository;

    /** @var ServiceProviderInterface */
    private $serviceProvider;

    public function __construct(
        ModuleRepositoryInterface $repository,
        ServiceProviderInterface $serviceProvider
    ) {
        $this->repository = $repository;
        $this->serviceProvider = $serviceProvider;
    }

    public function moduleById(int $id): ModuleBase
    {
        $moduleIdentity = ModuleIdentity::create($id);
        $moduleEntity = $this->repository->module($moduleIdentity);
        $module = $this->serviceProvider[$moduleEntity->getName()];
        return $module;
    }

    public function moduleByName(string $name): ModuleBase
    {
        $moduleName = ModuleName::create($name);
        $module = $this->serviceProvider[$moduleName()];
        return $module;
    }
}
