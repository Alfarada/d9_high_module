<?php

namespace Drupal\high;

use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class HighTypeListBuilder
 */
class HighListBuilder extends EntityListBuilder {

  protected $dateFormatter;

  protected $renderer;

  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatter $date_formatter, RendererInterface $renderer) {
    parent::__construct($entity_type, $storage);

    $this->dateFormatter = $date_formatter;
    $this->renderer = $renderer;
  }

  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter'),
      $container->get('renderer')
    );
  }

  public function buildHeader(){
    $header['id'] = $this->t('Linked Entity Id');
    $header['content_entity_label'] = $this->t('Content Entity Label');
    $header['content_entity_id'] = $this->t('Content Entity Id');
    $header['bundle_label'] = $this->t('Config Entity (Bundle) Label');
    $header['bundle_id'] = $this->t('Config Entity (Bundle) Id');

    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $entity) {
    $row['id'] = $entity->toLink($entity->id());
    $row['content_entity_label'] = $entity->getEntityType()->getLabel()->render();
    $row['content_entity_id'] = $entity->getEntityType()->id();
    $row['bundle_label'] = $entity->bundle->entity->label();
    $row['bundle_id'] = $entity->bundle();

    return $row + parent::buildRow($entity);
  }
}