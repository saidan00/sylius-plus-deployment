<?php

declare(strict_types=1);

namespace App\Entity\Shipping;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Core\Model\Shipment as BaseShipment;
use Sylius\Plus\Entity\ShipmentInterface;
use Sylius\Plus\Entity\ShipmentTrait;

/**
 * @Entity
 * @Table(name="sylius_shipment")
 */
class Shipment extends BaseShipment implements ShipmentInterface
{
    use ShipmentTrait;
}
