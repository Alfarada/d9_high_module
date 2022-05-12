<?php

namespace Drupal\high\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\UserInterface;

/**
 * Defines the High content entity.
 *
 * @ContentEntityType(
 *   id = "high",
 *   label = @Translation("High Content Entity"),
 *   base_table = "high",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "uid" = "uid",
 *     "label" = "name",
 *     "created" = "created",
 *     "changed" = "changed"
 *   },
 *   fieldable = TRUE,
 *   admin_permission = "administer high types",
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\high\HighListBuilder",
 *     "access" = "Drupal\high\HighEntityAccessControlHandler",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\high\Form\HighEntityForm",
 *       "add" = "Drupal\high\Form\HighEntityForm",
 *       "edit" = "Drupal\high\Form\HighEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   links = {
 *     "canonical" = "/high/{high}",
 *     "add-page" = "/high/add",
 *     "add-form" = "/high/add/{high_type}",
 *     "edit-form" = "/high/{high}/edit",
 *     "delete-form" = "/high/{high}/delete",
 *     "collection" = "/admin/content/highs",
 *   },
 *   bundle_entity_type = "high_type",
 *   field_ui_base_route = "entity.high_type.edit_form",
 * )
 */

class HighEntity extends ContentEntityBase implements HighEntityInterface
{
    use EntityChangedTrait;

    public function getName()
    {
        return $this->get('name')->value;
    }

    public function setName($name)
    {
        $this->set('name', $name);
        return $this;
    }

    public function getCreatedTime()
    {
        return $this->get('created')->value;
    }

    public function setCreatedTime($timestamp)
    {
        $this->set('created', $timestamp);
        return $this;
    }

    public function getOwner()
    {
        return $this->get('uid')->entity;
    }

    public function getOwnerId()
    {
        return $this->get('uid')->target_id;
    }

    public function setOwner(UserInterface $account)
    {
        $this->set('uid', $account->id());
        return $this;
    }

    public function setOwnerId($uid)
    {
        $this->set('uid', $uid);
        return $this;
    }

    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        $fields = parent::baseFieldDefinitions($entity_type);

        $fields['uid'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('Authored by'))
            ->setDescription(t('The user ID of author of the High entity.'))
            ->setSetting('target_type', 'user')
            ->setSetting('handler', 'default')
            ->setDisplayOptions('view', [
                'label' => 'hidden',
                'type' => 'author',
                'weight' => 0,
            ])
            ->setDisplayOptions('form', [
                'type' => 'entity_reference_autocomplete',
                'weight' => 5,
                'settings' => [
                    'match_operator' => 'CONTAINS',
                    'size' => '60',
                    'autocomplete_type' => 'tags',
                    'placeholder' => '',
                ],
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Name'))
            ->setDescription(t('The name of the High entity.'))
            ->setSettings([
                'max_length' => 50,
                'text_processing' => 0,
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'hidden',
                'type' => 'string',
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'string_textfield',
                'weight' => -4,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['created'] = BaseFieldDefinition::create('created')
            ->setLabel(t('Created'))
            ->setDescription(t('The time that the entity was created.'));

        $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel(t('Changed'))
            ->setDescription(t('The time that the entity was last edited.'));

        return $fields;
    }

    // changes the values of an entity before it is created
    public static function preCreate(EntityStorageInterface $storage_controller, array &$values)
    {
        parent::preCreate($storage_controller, $values);
        $values += [
            'uid' => \Drupal::currentUser()->id(),
        ];
    }
}
