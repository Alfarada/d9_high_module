<?php

namespace Drupal\high\Entity;

use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining High entity entities.
 *
 * @ingroup high
 */

interface HighEntityInterface extends EntityChangedInterface, EntityOwnerInterface
{
    public function getName();

    public function setName($name);

    public function getCreatedTime();

    public function setCreatedTime($timestamp);
}
