<?php

namespace App;

use Ngt\Larafm\Database\Model;

class Kintai extends Model
{
  public $timestamps = false;
  protected $layoutName = '勤怠管理';
  protected $fillable = [
    '社員番号',
    '出勤日',
    '出勤時間',
    '退勤時間',
    '勤怠区分',
  ];
}
