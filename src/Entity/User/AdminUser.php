<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Core\Model\AdminUser as BaseAdminUser;
use Sylius\Plus\Entity\AdminUserInterface;
use Sylius\Plus\Entity\AdminUserTrait;
use Sylius\Plus\Rbac\Domain\Model\RoleableTrait;
use Sylius\Plus\Rbac\Domain\Model\ToggleablePermissionCheckerTrait;

/**
 * @Entity
 * @Table(name="sylius_admin_user")
 */
class AdminUser extends BaseAdminUser implements AdminUserInterface
{
    use AdminUserTrait;
    use ToggleablePermissionCheckerTrait;
    use RoleableTrait;

    public function __construct()
    {
        parent::__construct();

        $this->rolesResources = new ArrayCollection();
    }
}
