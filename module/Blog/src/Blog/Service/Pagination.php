<?php
/**
 * Created by PhpStorm.
 * User: hpiso
 * Date: 04/02/16
 * Time: 20:07
 */

namespace Blog\Service;


class Pagination
{

    public function constructPagination($nbArticles, $currentPage, $maxPerPage)
    {
        $nextPage = null;
        $previousPage = null;

        // Calcul du nombre de pages en fonction du nombre d'articles
        $nbPages = $this->getPageCount($nbArticles, $maxPerPage);

        $currentPage = $currentPage > $nbPages ? $nbPages : $currentPage;

        $previousPage = $currentPage - 1 < 1 ? null : $currentPage - 1;
        $nextPage = $currentPage + 1 > $nbPages ? null : $currentPage + 1;

        return [
            'first' => 1,
            'last' => $nbPages,
            'current' => $currentPage,
            'previous' => $previousPage,
            'next' => $nextPage,
            'total' => $nbPages,
        ];

    }

    private function getPageCount($articleCount, $maxPerPage)
    {
        return ceil($articleCount / $maxPerPage);
    }


}