<?php

$admins = [
    ['email' => 'levickaite.m@gmail.com', 'pass' => md5('123')],
    ['email' => 'varliukasm@gmail.com', 'pass' => md5('123')],
    ['email' => 'eziukas@gmail.com', 'pass' => md5('123')],
];

$users = [
    ['id' => 1, 'name' => 'Agota', 'surname' => 'Kaminskaitė', 'personal-number' => 49007200000, 'iban' => '27 2249 7737 9136 5444', 'balance' => 0],
    ['id' => 2, 'name' => 'Martynas', 'surname' => 'Užubalis', 'personal-number' => 69003200660, 'iban' => '27 2249 7737 9136 2144', 'balance' => 0],
    ['id' => 3, 'name' => 'Liudmila', 'surname' => 'Krasovič', 'personal-number' => 24008500663, 'iban' => '27 2249 6987 9136 5444', 'balance' => 0],
    ['id' => 4, 'name' => 'Urtė', 'surname' => 'Neniškytė', 'personal-number' => 35008500663, 'iban' => '69 2249 6987 9136 5444', 'balance' => 0],
];

$id = 4;

file_put_contents(__DIR__ . '/admins', serialize($admins));
file_put_contents(__DIR__ . '/users', serialize($users));
file_put_contents(__DIR__ . '/users_id', serialize($id));
