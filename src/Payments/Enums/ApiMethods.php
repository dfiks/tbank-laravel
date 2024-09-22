<?php

namespace DFiks\TBank\Payments\Enums;

enum ApiMethods: string
{
    case Init = 'Init';
    case GetState = 'GetState';
    case CheckOrder = 'CheckOrder';
    case Cancel = 'Cancel';
}
