<?php

  // Формируем массив чисел.
  function fillArr($number)
  {
    $arr = [];
    for ($i = 1; $i <= $number; $i++) { $arr[] = $i; }

    return $arr;
  }

  // Функция для лексиграфического значения чисел. Возвращает true в случае, если первое число больше второго.
  // Если длина первого числа больше второго, то обрезаем первое число до длины второго.
  // Если длина второго числа больше первого, то обрезаем второе число до длины первого.
  // После того, как мы имеем числа одинаковой длины мы сравниваем их математически.
  // Если возникает ситуация, что мы после обрезания числа имеем математически равные числа(например, исходные числа 111 и 11,
  // обрезали первое до длины второго - получили 11 и 11) то считаем большим то число, которое изначально длиннее(111).
  function isFirstGreaterThenSecond($a, $b)
  {
    $aStr = (string)$a;
    $bStr = (string)$b;
    $aLen = strlen($aStr);
    $bLen = strlen($bStr);

    if ($aLen < $bLen) { $bStr = substr($bStr, 0, $aLen); }
    if ($aLen > $bLen) { $aStr = substr($aStr, 0, $bLen); }
      
    return ($aStr > $bStr || ($aStr == $bStr && $aLen > $bLen));
  }

  // Для сортировки массива используется алгоритм быстрой сортировки.
  // При помощи функции isFirstGreaterThenSecond определяем какое из двух числе больше.
  function qSort(&$arr, $first, $last)
  {
    $l = $first;
    $r = $last;

    // Расчёт опорного элемента, который используется для разделения массива на две части:
    // - слева от элемента находятся "маленькие"" числа
    // - справа от элемента - "большие"
    $pivot = $arr[(int)($l + $r) / 2];

    while ($l <= $r) {
      // Пока не найдено число больше опорного("большое" число в левой части массива), движемся вправо по массиву.
      while (isFirstGreaterThenSecond($pivot, $arr[$l])) { $l++; }
      // Пока не найдено число меньше опорного("маленькое" число в правой части массива), движемся влево по массиву.
      while (isFirstGreaterThenSecond($arr[$r], $pivot)) { $r--; }

      // Меняем местами "большое" число из левой части с "маленьким" числом из правой части.
      if ($l <= $r) {
        $temp = $arr[$l];
        $arr[$l] = $arr[$r];
        $arr[$r] = $temp;
        $l++; $r--;
      }
    }
    // Рекурсивно вызываем функцию для сортировки левой части массива("маленькие" числа).
    if ($first < $r) { qSort($arr, $first, $r); }
    // Рекурсивно вызываем функцию для сортировки правой части массива("маленькие" числа).
    if ($last > $l) { qSort($arr, $l, $last); }
  }

  // Для нахождения позиции элемента в массива используется бинарный поиск.
  // При помощи функции isFirstGreaterThenSecond определяем какое из двух числе больше.
  function binarySearch($arr, $k)
  {
    $f = 0;
    $l = sizeof($arr) - 1;

    do {
      $i = (int)(($f + $l) / 2);
      if (isFirstGreaterThenSecond($arr[$i], $k)) { $l = $i--; }
      elseif (isFirstGreaterThenSecond($k, $arr[$i])) { $f = $i++; }
    } while ($k != $arr[$i]);

    return ++$i;
  }

  // Итоговая функция.
  function findNumberPos($number, $k)
  {
    $arr = fillArr($number);
    $first = 0;
    $last = sizeof($arr) - 1;
    
    qSort($arr, $first, $last);

    return binarySearch($arr, $k);
  }

    echo findNumberPos(11, 2);

?>