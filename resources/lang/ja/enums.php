<?php

use App\Enums\SupportStatus;

return [

  SupportStatus::class=> [
    SupportStatus::OpNew  => '新規',
    SupportStatus::OpOpen => '対応中',
    SupportStatus::OpDone => '対応完了',
  ],
];