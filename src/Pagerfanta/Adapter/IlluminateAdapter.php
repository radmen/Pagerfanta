<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pagerfanta\Adapter;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * IlluminateAdapter
 *
 * Adapter for Laravel database/eloquent builder
 *
 * @author Radoslaw Mejer <radmen@gmail.com>
 */
class IlluminateAdapter implements AdapterInterface
{

  private $builder;

  public function __construct($builder) 
  {

    if(false === $builder instanceof QueryBuilder && false === $builder instanceof EloquentBuilder)
    {
      throw new \Pagerfanta\Exception\InvalidArgumentException;
    }

    $this->builder = $builder;
  }

  /**
   * {@inheritdoc}
   */
  public function getSlice($offset, $length)
  {
    return $this->builder
      ->skip($offset)
      ->take($length)
      ->get();
  }

  public function getNbResults()
  {
    $query = $this->builder;

    if(true === $this->builder instanceof EloquentBuilder)
    {
      $query = $this->builder->getQuery();
    }

    return $query->getPaginationCount();
  }

}
