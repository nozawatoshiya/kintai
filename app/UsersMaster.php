<?php

namespace App;

use Ngt\Larafm\Database\Model;

class UsersMaster extends Model
{
  public $timestamps = false;
  protected $layoutName = 'ユーザーテーブル';
  protected $fillable = [
    '社員番号',
  ];
}
