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

function currentHourAndMinute()
{
    return Carbon::now()->format('H:m');
}

function specificHourAndMinute($date)
{
    return Carbon::parse($date)->format('H:i');
}

function currentYearMonthDayHourAndMinute()
{
    return Carbon::now()->format('Y-m-d H:m');
}

function specificYearMonthDayHourAndMinute($date)
{
    return Carbon::parse($date)->format('Y-m-d H:m');
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
        $months[] = specificMonthNameShortFormat('2000-' . $m . '-1');
    }
    return $months;
}

function allMonthsInYearLongFormat()
{
    $months = [];
    for ($m = 1; $m <= 12; $m++) {
        $months[] = specificMonthNameLongFormat('2000-' . $m . '-1');
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

function min_date(array $date)
{
    $timestamps = array_map('strtotime', $date);
    return date('Y-m-d', min($timestamps));
}

function max_date(array $date)
{
    $timestamps = array_map('strtotime', $date);
    return  date('Y-m-d', max($timestamps));
}

function isInsideOfInterval(array $interval, $date)
{
    $dateTimeToCheck = Carbon::parse($date);
    $startDateTime = Carbon::parse(min_date($interval));
    $endDateTime = Carbon::parse(max_date($interval));

    return $dateTimeToCheck->between($startDateTime, $endDateTime, true);
}

function isDayBeforeToday(string $dateToCheck)
{
    $dateTimeToCheck = Carbon::parse($dateToCheck);
    $today = Carbon::now();

    return $dateTimeToCheck->lt($today);
}

function hours_difference(string $dateTime1, string $dateTime2)
{
    $start = Carbon::parse($dateTime1);
    $end = Carbon::parse($dateTime2);

    return $end->diffInHours($start);
}

function lastDayOfNextMonth($dataReferinta = null)
{
    // Dacă nu se furnizează o dată de referință, se utilizează data de astăzi
    if ($dataReferinta === null) {
        $dataReferinta = Carbon::today();
    } else {
        $dataReferinta = Carbon::parse($dataReferinta);
    }

    $nextMonth = $dataReferinta->copy()->addMonth()->startOfMonth();
    $lastDayOfNextMonth = $nextMonth->copy()->addMonth()->subDay();

    return $lastDayOfNextMonth->format('Y-m-d');
}

function firstDayOfCurrentMonth($date)
{
    return Carbon::parse($date)->startOfMonth()->toDateString();
}

function lastDayOfCurrentMonth($date)
{
    return Carbon::parse($date)->endOfMonth()->toDateString();
}

function lastDayOfSpecificMonth($dataReferinta = null)
{
    $dataReferinta = Carbon::parse($dataReferinta);

    $lastDayOfMonth = $dataReferinta->endOfMonth();

    return $lastDayOfMonth->format('Y-m-d');
}

function firstDayOfPrevMonth($dataReferinta = null)
{
    // Dacă nu se furnizează o dată de referință, se utilizează data de astăzi
    if ($dataReferinta === null) {
        $dataReferinta = Carbon::today();
    } else {
        $dataReferinta = Carbon::parse($dataReferinta);
    }

    $dataReferinta->startOfMonth();
    $primaZiDinLunaPrecedenta = $dataReferinta->subMonth()->startOfMonth();

    return $primaZiDinLunaPrecedenta->format('Y-m-d');
}

function firstDayOfSpecificMonth($dataReferinta = null)
{
    $dataReferinta = Carbon::parse($dataReferinta);

    $firstDayOfMonth = $dataReferinta->startOfMonth();

    return $firstDayOfMonth->format('Y-m-d');
}

function isDateGraterThan(string $date1, string $date2)
{
    $date1 = Carbon::parse($date1);
    $date2 = Carbon::parse($date2);

    return $date2->gte($date1);
}

function getFirstAndLastDate(string $date1, string $date2): array
{
    $dateTime1 = Carbon::parse($date1);
    $dateTime2 = Carbon::parse($date2);

    if ($dateTime1->lt($dateTime2)) {
        $first = $date1;
        $last = $date2;
    } else {
        $first = $date2;
        $last = $date1;
    }

    return ['first' => $first, 'last' => $last];
}
