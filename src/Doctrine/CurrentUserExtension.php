<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Mission;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\User;

final readonly class CurrentUserExtension implements QueryCollectionExtensionInterface
{
    public function __construct(
        private Security $security
    )
    {
        
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function addWhere(QueryBuilder $queryBuilder, string $resourceClass):void
    {
        /** @var \App\Entity\User */
        $user = $this->security->getUser();
        if (Mission::class !== $resourceClass || null === $user) {
            return;
        }



        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
        $queryBuilder->setParameter('current_user', $user->getId());
    }
}