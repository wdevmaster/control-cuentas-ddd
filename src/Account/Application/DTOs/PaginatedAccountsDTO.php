<?php

namespace Bank\Account\Application\DTOs;

class PaginatedAccountsDTO
{
    public function __construct(
        private array $accounts,
        private int $page,
        private int $pageSize,
        private int $totalItems
    ){}

    /**
     * Obtiene la lista de cuentas.
     *
     * @return array La lista de cuentas.
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * Obtiene el número de página actual.
     *
     * @return int El número de página actual.
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Obtiene el tamaño de la página.
     *
     * @return int El tamaño de la página.
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * Obtiene el número total de elementos.
     *
     * @return int El número total de elementos.
     */
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * Calcula y obtiene el número total de páginas.
     *
     * @return int El número total de páginas.
     */
    public function getTotalPages(): int
    {
        return (int) ceil($this->totalItems / $this->pageSize);
    }

    /**
     * Converts the DTO object into an associative array.
     *
     * @return array The associative array representing the DTO object.
     */
    public function toArray(): array
    {
        return [
            'data' => $this->getAccounts(),
            'current_page' => $this->getPage(),
            'per_page' => $this->getPageSize(),
            'total' => $this->getTotalItems(),
            'last_page' => $this->getTotalPages(),
        ];
    }
}
