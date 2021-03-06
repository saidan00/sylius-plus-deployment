<?php

declare(strict_types=1);

namespace App\Entity\Channel;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Plus\Entity\ChannelInterface;
use Sylius\Plus\Entity\ChannelTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @Entity
 * @Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements ChannelInterface
{
    use ChannelTrait;
}
