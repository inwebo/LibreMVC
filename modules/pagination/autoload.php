<?php
LibreMVC\AutoLoader::instance()->addPool( './' );

define('TPL_PAGINATION', __DIR__ . '/views/tpl/pagination.php');

function renderPagination($pagination, $baseUri, $activeClass= "", $intervalSize = 10) {
    $vo = new \LibreMVC\View\ViewObject();

    $vo->min = $pagination->min;
    $vo->max = $pagination->max;
    $vo->index = (int)$pagination->index;

    $vo->hasNext = $pagination->next();
    $vo->next = ($vo->hasNext) ? $pagination->index + 1 : null;

    $vo->hasPrev = $pagination->prev();
    $vo->prev = ($vo->hasPrev) ? $pagination->index - 1 : null;

    $vo->baseUri = $baseUri;
    $vo->activeClass = $activeClass;

    $vo->interval = new \StdClass();
    $interval = $pagination->getInterval($intervalSize);
    $vo->interval->start = $interval[0];
    $vo->interval->stop = $interval[1];
    partial(TPL_PAGINATION, $vo);
}