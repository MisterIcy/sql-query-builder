# SqlQueryBuilder

[![codecov](https://codecov.io/gh/MisterIcy/sql-query-builder/branch/0.1.x/graph/badge.svg?token=0YFW6EOOJ5)](https://codecov.io/gh/MisterIcy/sql-query-builder)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MisterIcy/sql-query-builder/badges/quality-score.png?b=0.1.x)](https://scrutinizer-ci.com/g/MisterIcy/sql-query-builder/?branch=0.1.x)
[![Build Status](https://scrutinizer-ci.com/g/MisterIcy/sql-query-builder/badges/build.png?b=0.1.x)](https://scrutinizer-ci.com/g/MisterIcy/sql-query-builder/build-status/0.1.x)
[![Coding Standards](https://github.com/MisterIcy/sql-query-builder/actions/workflows/coding-standards.yml/badge.svg)](https://github.com/MisterIcy/sql-query-builder/actions/workflows/coding-standards.yml)
[![Static Analysis](https://github.com/MisterIcy/sql-query-builder/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/MisterIcy/sql-query-builder/actions/workflows/static-analysis.yml)


SQL Query Crafter for MySQL/MariaDB

## History

I no longer remember how many times I had to hand-craft and optimize a query for a particular case in various PHP projects. In order to perform the aforementioned optimizations, I had to resort to bad practices, ugly code and extreme string manipulation. Until I said _no more_.

This project is based on an older, similar project of mine, written in C#. 

## About the Project

SqlQueryBuilder is written in modern PHP and can run on all actively supported versions of PHP (7.4+). It is not an optimizer, nor it generates queries out of thin air; it's purpose is to simplify a developer's life by giving them the power to build their queries on demand. 

The project is currently under development. 

## Usage

The QueryBuilder uses a fluid design, where you can chain call methods:

```php
use MisterIcy\SqlQueryBuilder\QueryBuilder;
use MisterIcy\SqlQueryBuilder\Operations\IsNotNull;
use MisterIcy\SqlQueryBuilder\Operations\Eq;

$queryBuilder = new QueryBuilder();
$query = $queryBuilder->select()
    ->from('testTable', 't')
    ->where(new IsNotNull('t.timestamp'))
    ->andWhere(new Eq('t.archived', 0))
    ->getQuery();
```

This will produce:

```mysql
SELECT * FROM testTable `t` WHERE t.timestamp IS NOT NULL AND t.archived = 0
```
