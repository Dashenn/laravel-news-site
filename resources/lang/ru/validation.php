<?php
return [
    'required' => 'Поле :attribute обязательно для заполнения.',
    'email' => 'Введите корректный email.',
    'confirmed' => 'Пароли не совпадают.',
    'min' => [
        'string' => 'Поле :attribute должно содержать минимум :min символов.',
    ],
    'max' => [
        'string' => 'Поле :attribute не должно превышать :max символов.',
    ],
    'unique' => 'Значение поля :attribute уже занято.',
    'custom' => [
        'name' => [
            'unique' => 'Значение поля Login уже занято.',
        ],

        'password' => [
            'required' => 'Поле Пароль обязательно для заполнения.',
        ],

    ],
    'mimes' => 'Поле :attribute должно быть файлом одного из следующих типов: :values.',

];
