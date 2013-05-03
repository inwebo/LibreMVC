<?php
use LibreMVC\Views\Template\ViewBag as ViewBag;

ViewBag::get()->foo = 'basr';
?>
<h2>{$title}</h2>

Lorem ipsum dolor {$test} amet, consectetur adipisicing elit, sed do eiusmod tempor {noparse}[
{CONSTANTE} ]<--No parse
{/noparse} incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
<b>{CONSTANTE}</b>.
<a href="controller/action">Test</a>
{$foo}
<hr>
{$nexistepas}{TEST}
<hr>
<ul>
    {loop="$array"}

    <li> {$key},{$value}</li>

    {/loop}
</ul>
<ul>
    {loop="$object"}

    <li> {$key},{$value}</li>

    {/loop}
</ul>
<ul>
    {loop="$void"}

    <li> {$key},{$value}</li>

    {/loop}
</ul>
<hr>
{tpl="sharedview.php"}
<hr>
{include="README.md"}{include="READssME.md"}
<hr>
{if "{$isTrue}==={$isTrue}"}<br>
debut vrai<br>
{$test}<br>
fin vrai<br>
{else}<br>
debut faux<br>
faux<br>
fin faux<br>
{fi}<br>