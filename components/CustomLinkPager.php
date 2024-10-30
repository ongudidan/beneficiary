<?php

namespace app\components;

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;

class CustomLinkPager extends LinkPager
{
    protected function renderPageButtons(): string
    {
        $buttons = [];
        $currentPage = $this->pagination->page;
        $totalPages = $this->pagination->pageCount;

        // Display "Start" button
        $buttons[] = $this->renderPageButton(
            'Start',
            0,
            'page-item' . ($currentPage <= 0 ? ' disabled' : ''),
            $currentPage <= 0,
            false
        );

        // Display "Previous" button
        $buttons[] = $this->renderPageButton(
            $this->prevPageLabel,
            $currentPage - 1,
            'page-item' . ($currentPage <= 0 ? ' disabled' : ''),
            $currentPage <= 0,
            false
        );

        // Set the sliding window of 5 pages
        $startPage = max(0, $currentPage - 2);
        $endPage = min($totalPages, $startPage + 5);

        // Adjust startPage if near the end
        if ($endPage - $startPage < 5) {
            $startPage = max(0, $endPage - 5);
        }

        // Show the calculated range of pages
        for ($i = $startPage; $i < $endPage; $i++) {
            $buttons[] = $this->renderPageButton(
                $i + 1,
                $i,
                'page-item' . ($i == $currentPage ? ' active' : ''),
                $i == $currentPage,
                false
            );
        }

        // Add dots if there are more pages after the sliding window
        if ($endPage < $totalPages - 2) {
            $buttons[] = Html::tag('li', '...', ['class' => 'page-item disabled']);
        }

        // Show the last 2 pages
        for ($i = max($endPage, $totalPages - 2); $i < $totalPages; $i++) {
            $buttons[] = $this->renderPageButton(
                $i + 1,
                $i,
                'page-item' . ($i == $currentPage ? ' active' : ''),
                $i == $currentPage,
                false
            );
        }

        // Display "Next" button
        $buttons[] = $this->renderPageButton(
            $this->nextPageLabel,
            $currentPage + 1,
            'page-item' . ($currentPage >= $totalPages - 1 ? ' disabled' : ''),
            $currentPage >= $totalPages - 1,
            false
        );

        // Display "End" button
        $buttons[] = $this->renderPageButton(
            'End',
            $totalPages - 1,
            'page-item' . ($currentPage >= $totalPages - 1 ? ' disabled' : ''),
            $currentPage >= $totalPages - 1,
            false
        );

        // Return the concatenated string of buttons
        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }
}
