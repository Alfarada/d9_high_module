<?php

namespace Drupal\high\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the  HighType entity. A configuration entity used to manage
 * bundles for the High entity.
 *
 * @ConfigEntityType(
 *   id = "high_type",
 *   label = @Translation("High Type"),
 *   bundle_of = "high",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_prefix = "high_type",
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\high\HighTypeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\high\Form\HighTypeEntityForm",
 *       "add" = "Drupal\high\Form\HighTypeEntityForm",
 *       "edit" = "Drupal\high\Form\HighTypeEntityForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer high types",
 *   links = {
 *     "canonical" = "/admin/structure/high_type/{high_type}",
 *     "add-form" = "/admin/structure/high_type/add",
 *     "edit-form" = "/admin/structure/high_type/{high_type}/edit",
 *     "delete-form" = "/admin/structure/high_type/{high_type}/delete",
 *     "collection" = "/admin/structure/high_type",
 *   }
 * )
 */
class HighTypeEntity extends ConfigEntityBundleBase implements HighTypeEntityInterface
{

    protected $id;

    protected $label;

    protected $description;

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}
