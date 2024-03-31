<?php

use Illuminate\Support\Carbon;
use Label84\HoursHelper\Facades\HoursHelper;

function currentYear()
{
    return strval(Carbon::now()->year);
}

function specificYear($date)
{
    return Carbon::parse($date)->year;
}

function currentMonth()
{
    return strval(Carbon::now()->month);
}

function specificMonth($date)
{
    return Carbon::parse($date)->month;
}

function currentDay()
{
    return strval(Carbon::now()->day);
}

function specificDay($date)
{
    return Carbon::parse($date)->day;
}

function currentHour()
{
    return strval(Carbon::now()->hour);
}

function currentMinute()
{
    return strval(Carbon::now()->minute);
}

function currentSecond()
{
    return strval(Carbon::now()->second);
}

function currentYearAndMonth()
{
    return Carbon::now()->format('Y-m');
}

function specificYearAndMonth($date)
{
    return Carbon::parse($date)->format('Y-m');
}

function currentYearMonthAndDay()
{
    return Carbon::now()->format('Y-m-d');
}

function currentYearMonthAndDaySimpleFormat()
{
    return Carbon::now()->format('Y-n-j');
}

function specificYearMonthAndDay($date)
{
    return Carbon::parse($date)->format('Y-m-d');
}

function currentYearMonthDayHourAndMinute()
{
    return Carbon::now()->format('Y-m-d H:m');
}

function currentYearMonthDayHourMinuteAndSecond()
{
    return Carbon::now()->format('Y-m-d H:m:s');
}

function numberOfDaysInCurrentMonth()
{
    return numberOfDaysInSpecificMonth(currentYearAndMonth());
}

function numberOfDaysInSpecificMonth($date)
{
    return Carbon::parse($date)->daysInMonth;
}

function currentDayNameShortFormat()
{
    return specificDayNameShortFormat(currentYearMonthAndDay());
}

function specificDayNameShortFormat($date)
{
    return ucfirst(Carbon::parse($date)->translatedFormat('D'));
}

function currentDayNameLongFormat()
{
    return specificDayNameLongFormat(currentYearMonthAndDay());
}

function specificDayNameLongFormat($date)
{
    return ucfirst(Carbon::parse($date)->dayName);
}

function currentMonthNameShortFormat()
{
    return specificMonthNameShortFormat(currentYearAndMonth());
}

function specificMonthNameShortFormat($date)
{
    return ucfirst(Carbon::parse($date)->translatedFormat('M'));
}

function currentMonthNameLongFormat()
{
    return specificMonthNameLongFormat(currentYearAndMonth());
}

function specificMonthNameLongFormat($date)
{
    return ucfirst(Carbon::parse($date)->translatedFormat('F'));
}

function currentStartDateOfMonth()
{
    return specificStartDateOfMonth(currentYearAndMonth());
}

function specificStartDateOfMonth($date)
{
    return Carbon::parse($date)->startOfMonth()->toDateString();
}

function currentEndDateOfMonth()
{
    return specificEndDateOfMonth(currentYearAndMonth());
}

function specificEndDateOfMonth($date)
{
    return Carbon::parse($date)->endOfMonth()->toDateString();
}

function nameOfDaysWeek()
{
    $nameOfDaysOfWeek = [];
    $daysOfWeek = daysBetween('2018-01-01', '2018-01-7');

    foreach ($daysOfWeek as $date) {
        $nameOfDaysOfWeek[] = specificDayNameLongFormat($date);
    }

    return $nameOfDaysOfWeek;
}

function prevMonth($date)
{
    return Carbon::parse($date)->subMonth()->toDateString();
}

function nextMonth($date)
{
    return Carbon::parse($date)->addMonth()->toDateString();
}

function prevYear($date)
{
    return Carbon::parse($date)->subYear()->toDateString();
}

function nextYear($date)
{
    return Carbon::parse($date)->addYear()->toDateString();
}

function currentMonthDays($format = 'Y-m-d')
{
    return daysBetween(currentStartDateOfMonth(), currentEndDateOfMonth(), $format);
}

function specificMonthDays($date)
{
    return daysBetween(specificStartDateOfMonth($date), specificEndDateOfMonth($date), 'Y-m-d');
}


function daysBetween($startDate_str, $endDate_str, $dateFormat_str = 'Y-m-d')
{
    return HoursHelper::create($startDate_str, $endDate_str, 60 * 24, $dateFormat_str);
}

function allMonthsInYearShortFormat()
{
    $months = [];
    for ($m = 1; $m <= 12; $m++) {
        $months[] = specificMonthNameShortFormat('2000-'.$m.'-1');
    }
    return $months;
}

function allMonthsInYearLongFormat()
{
    $months = [];
    for ($m = 1; $m <= 12; $m++) {
        $months[] = specificMonthNameLongFormat('2000-'.$m.'-1');
    }
    return $months;
}

function currentYearAndLongFormatMonth()
{
    return currentMonthNameLongFormat() . ' ' . currentYear();
}

function specificYearAndLongFormatMonth($date)
{
    return specificMonthNameLongFormat($date) . ' ' . specificYear($date);
}

function recreateYearMonthDayWithSpecificDate($year, $month, $day)
{
    return specificYear($year) . '-' . specificMonth($month) . '-' . specificDay($day);
}

function recreateYearMonthWithFirstDay($year, $month)
{
    return specificYear($year) . '-' . specificMonth($month) . '-1';
}

function recreateYearMonthDay($year, $month, $day)
{
    return $year . '-' . $month . '-' . $day;
}

function firstDayOTheMonth($date)
{
    return Carbon::parse($date)->format('Y-m-01');
}
