<?php

declare(strict_types=1);

namespace Oc\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class CacheDescRepository
{
    private const TABLE = 'cache_desc';

    public function __construct(
        private Connection $connection,
    ) {}

    /** @throws Exception */
    public function fetchDescription(int $cacheId, string $preferredLang): ?array
    {
        $result = $this->connection->createQueryBuilder()
            ->select('cd.desc', 'cd.hint', 'cd.short_desc', 'cd.desc_html', 'cd.desc_dark_unsafe', 'cd.language')
            ->from(self::TABLE, 'cd')
            ->where('cd.cache_id = :cacheId')
            ->orderBy('cd.language = :preferredLang', 'DESC')
            ->addOrderBy("cd.language = 'EN'", 'DESC')
            ->setMaxResults(1)
            ->setParameters(['cacheId' => $cacheId, 'preferredLang' => $preferredLang])
            ->executeQuery()
            ->fetchAssociative();

        return $result ?: null;
    }

    /** @throws Exception */
    public function fetchDescriptionForEdit(int $cacheId): ?array
    {
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE)
            ->where('cache_id = :cacheId')
            ->orderBy('id')
            ->setMaxResults(1)
            ->setParameter('cacheId', $cacheId)
            ->executeQuery()
            ->fetchAssociative();

        return $result ?: null;
    }

    /** @throws Exception */
    public function insertDescription(int $cacheId, array $data): void
    {
        $data['cache_id'] = $cacheId;
        $cols = array_map(fn($c) => "`$c`", array_keys($data));
        $placeholders = array_map(fn($c) => ":$c", array_keys($data));
        $params = [];
        foreach ($data as $k => $v) $params[$k] = $v;
        $this->connection->executeStatement(
            sprintf("INSERT INTO %s (%s) VALUES (%s)", self::TABLE, implode(", ", $cols), implode(", ", $placeholders)),
            $params
        );
    }

    /** @throws Exception */
    public function updateDescription(int $cacheId, array $data): void
    {
        $sets = array_map(fn($c) => "`$c` = :$c", array_keys($data));
        $params = [];
        foreach ($data as $k => $v) $params[$k] = $v;
        $params["cacheId"] = $cacheId;
        $this->connection->executeStatement(
            sprintf("UPDATE %s SET %s WHERE `cache_id` = :cacheId", self::TABLE, implode(", ", $sets)),
            $params
        );
    }
}
