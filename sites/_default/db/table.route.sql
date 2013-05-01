CREATE TABLE routes (
    "name" TEXT DEFAULT (''),
    "pattern" TEXT UNIQUE DEFAULT ('[/][:action][/]'),
    "controller" TEXT NOT NULL DEFAULT ('\LibreMVC\Controllers\HomeController'),
    "action" TEXT NOT NULL DEFAULT ('index')
);