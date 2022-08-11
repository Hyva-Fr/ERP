<?php

namespace App\Filters;

use Illuminate\Http\Request;

class FormFilters
{
    private static string $filterKey;
    private static string $orderBy;
    private static int $perPage;
    private static string $search;
    private static ?string $searchKey;
    private static ?object $entity;
    private static ?array $keys;
    private static ?string $table;
    
    public static function getFilteredCollection(Request $request, $query, $keys, $table): object
    {
        self::$entity = $query;
        self::$keys = $keys;
        self::$table = $table;
        self::setFilters($request);
        return self::applyFilters();
    }
    
    public static function setFilters(Request $request): void
    {
        self::$filterKey = ($request->input('filter') === 'none' || $request->input('filter') === null)
            ? 'id' 
            : $request->input('filter');
        
        self::$orderBy = ($request->input('order') !== null)
            ? $request->input('order')
            : 'asc';

        self::$perPage = ($request->input('pagination') !== null)
            ? (int) $request->input('pagination')
            : 10;

        self::$search = ($request->input('search') !== null)
            ? $request->input('search')
            : '';

        self::$searchKey = (self::$filterKey === 'id')
            ? null
            : self::$filterKey;
    }
    
    private static function applyFilters(): object
    {
        $entity = self::$entity;
        if (self::$search !== '') {
            if (self::$searchKey !== null) {
                $entity->where(self::$table . '.' . self::$searchKey, 'like', '%' . self::$search . '%');
            } else {
                $cnt = 0;
                foreach (self::$keys as $key) {
                    if ($cnt === 0) {
                        $entity->where(self::$table . '.' . $key, 'like', '%' . self::$search . '%');
                    } else {
                        $entity->orWhere(self::$table . '.' . $key, 'like', '%' . self::$search . '%');
                    }
                    $cnt++;
                }
            }
        }
        return $entity
            ->orderBy(self::$table . '.' . self::$filterKey, self::$orderBy)
            ->paginate(self::$perPage);
    }
}