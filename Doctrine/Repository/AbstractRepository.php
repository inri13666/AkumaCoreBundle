<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/16/15
 * Time  : 7:27 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\CoreBundle\Doctrine\Repository;


use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return null|object
     *
     */
    public function getRandomEntity($id = null)
    {
        $data = $this->getRandomEntities($id, 1);
        return reset($data);
    }

    public function getRandomEntities($id = null, $count = 5)
    {
        $query = $this->createQueryBuilder('q')
            ->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->setMaxResults($count);
        if (!is_null($id)) {
            if (is_array($id)) {
                $query->where($query->expr()->notIn('q.id', $id));
            } elseif (is_numeric($id)) {
                $query->where($query->expr()->neq('q.id', $id));
            }
        }
        return $query->getQuery()->getResult() ? : array();
    }
} 