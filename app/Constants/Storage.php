<?php


namespace App\Constants;


class Storage
{
    //Директория для ПОСТОЯННОГО хранения файлов
    const LONG_STORAGE_PATH = 'upload';

    //Директория для ВРЕМЕННОГО хранения файлов
    const TEMPORARY_STORAGE_PATH = 'tmp';

    //Константы определяющие способ сохранения файла
    const LONG_TERM_FILE = 1; //долговременное сохранения файла с записью в бд
    const TMP_FILE = 2; //Временное сохранения, без записи в бд
}
