<?php

namespace Deployer;

require 'recipe/common.php';
require 'contrib/rsync.php';

host('prod')
    ->set('hostname', 'access964308919.webspace-data.io')
    ->set('remote_user', 'u112422749')
    ->set('labels', ['stage' => 'prod'])
    ->set('deploy_path', '/kunden/homepages/2/d964308919/htdocs/deployment')
    ->set('repository', 'https://github.com/wolf-utz/utz-it.de')
    ->set('php_path', '/usr/bin/php8.1');

set('bin_folder', './vendor/bin/');
set('typo3_webroot', 'public');
set('rsync_src', './');
set('rsync', [
    'exclude' => [
        'deploy.php',
        '.docker*',
        '.editorconfig',
        '.github',
        '.env*',
        '.git*',
        '.surf',
        '.deployer',
        '.ci',
        './bin',
        'tests',
        'docker-compose.yml',
        'README.md',
        'CHANGELOG.md',
        'node_modules'
    ],
    'exclude-file' => false,
    'include' => [],
    'include-file' => false,
    'filter' => [],
    'filter-file' => false,
    'filter-perdir' => false,
    'flags' => 'rz', // Recursive, with compress
    'options' => ['delete', 'times', 'perms', 'links', 'delete-excluded'],
    'timeout' => 600,
]);

task('symfony:doctrine:migrations:migrate', function () {
    run('cd {{release_path}} && {{php_path}} vendor/bin/console --no-interaction doctrine:migrations:migrate');
});

task('symfony:cache:clear', function () {
    run('cd {{release_path}} && {{php_path}} vendor/bin/console --no-interaction cache:clear');
});

task('composer:install', function () {
    runLocally('composer -q install --no-dev');
});

task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'composer:install',
    'deploy:release',
    'rsync',
    'deploy:shared',
    'symfony:doctrine:migrations:migrate',
    'symfony:cache:clear',
    'deploy:publish'
])->desc('Deploy');

after('deploy:failed', 'deploy:unlock');
