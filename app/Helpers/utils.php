<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/*
|--------------------------------------------------------------------------
| Step - 5 (multiLanguage - v0.1)
|--------------------------------------------------------------------------
|
| Copy and paste dinamicRoutes() method in your Helper file.
|
*/

function dinamicRoutes($rutaSiCheileDeTraducere, $controllerulRutelor)
{
    foreach ($rutaSiCheileDeTraducere as $key => $value) {
        foreach ($value as $locale => $routeConfig) {
            Route::get('/' . $locale . $routeConfig, [$controllerulRutelor[$key], 'show_' . $key])
                ->name($key . '_' . $locale);
        }
    }
}

/*
|--------------------------------------------------------------------------
| Step - 8 (multiLanguage - v0.1)
|--------------------------------------------------------------------------
|
| With checkPrefix() method you check in controller if selected language is the language we set in config -> app.supported_languages
|
*/

// public function howToEmit()
// {
//     // $this->emit('show', 111);
//     // $this->emitTo('components.services-modal', 'show', '1111');
// }


function checkPrefix($string)
{
    return preg_match(config('app.regex_supported_languages'), $string);
}

function handleModel(Model $param1, string $param2, array $param3 = []): array | Model | Builder
{
    return call_user_func([$param1, $param2], $param3);
}

function webSiteLang()
{
    return str_replace('_', '-', app()->getLocale());
}

function isAllowedRoute(array $allowedRoutes): bool
{
    return in_array(request()->route()->getName(), $allowedRoutes);
}

function getConstant(string $constantKey)
{
    return config('constants.' . $constantKey);
}

function isNotEmpty($value): bool
{
    return !empty($value);
}

function setProperties(string $property, $value = null, string $type = null): string | null
{

    $withoutPlaceholder = ['checkbox', 'radio'];
    $withLabelString = ['id', 'for'];

    if (empty($value) || ($property === 'placeholder' && in_array($type, $withoutPlaceholder))) {
        return null;
    }

    $domProperty = $property . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';

    switch ($property) {
        case (in_array($property, $withLabelString)):
            return $property . '="' . htmlspecialchars($value, ENT_QUOTES) . '-label"';

        default:
            return $domProperty;
    }
}

function hasValue($value, string $stringError)
{
    if (!$value) {
        return $stringError;
    }

    return $value;
}

function isAdmin()
{
    if (empty(Auth::user())) {
        return false;
    }

    return (bool) Auth::user()->is_admin;
}

function getCurrentRouteName()
{
    return Route::currentRouteName();
}

function firstElement(array $tableData)
{
    return reset($tableData);
}

function tableHead(array $tableData, array $endArr = [], array $startArr = [])
{
    $keys = array_keys(firstElement($tableData));
    $start = array_merge($startArr, $keys);
    return array_merge($start, $endArr);
}

function modifArray(array $arr = [], array $modif = [])
{
    foreach ($arr as &$item) {
        if (isset($item['key'])) {
            $item['key'] .= $modif['key'];
        }
    }

    return $arr;
}

function handleModalAddData(string $operation = '', array $modalData = [], bool $inhibModalClosure = false)
{
    // $arr = [];
    $dataToEncode = [];

    if (isset($operation)) {
        $dataToEncode['operation'] = $operation;
    }

    if (isset($inhibModalClosure)) {
        $dataToEncode['inhibModalClosure'] = $inhibModalClosure;
    }

    $dataToEncode['rowData'] = [];

    return json_encode($dataToEncode);
}

function handleModalData(int $rowId, string $operation = '', array $modalData = [], bool $inhibModalClosure = false)
{
    $dataToEncode = [];

    if (isset($operation)) {
        $dataToEncode['operation'] = $operation;
    }

    if (isset($rowId)) {
        $dataToEncode['rowId'] = $rowId + 1;
    }

    if (isset($inhibModalClosure)) {
        $dataToEncode['inhibModalClosure'] = $inhibModalClosure;
    }

    $dataToEncode['id'] = $modalData['id'];

    unset($modalData['id']);

    $dataToEncode['rowData'] = $modalData;

    return json_encode($dataToEncode);
}

function handleModalDeleteData(array $modalData = [], bool $inhibModalClosure = false)
{
    $dataToEncode['operation'] = 'delete';
    
    if (isset($inhibModalClosure)) {
        $dataToEncode['inhibModalClosure'] = $inhibModalClosure;
    }

    $dataToEncode['rowData'] = $modalData;

    return json_encode($dataToEncode);
}

function handleEmitTo(string $componentPath, string $methodName, $data)
{
    return '$emitTo("' . $componentPath . '", "' . $methodName . '" ,' . $data . ')';
}

function handlePlaceholder(string $value, string $type = 'add')
{
    switch ($type) {
        case 'add':
            return __('translations.add') . ' ' . $value;

        default:
            return $value;
    }
}

function handleLivewireTableIds(int $index, object $data)
{
    return $index + ($data->currentPage() - 1) * $data->perPage() + 1;
}

function handleTableBody(array $data, array $fields = [])
{
    if (empty($data)) {
        return;
    }

    $arr = [];

    foreach ($fields as $key) {
        if (array_key_exists($key, $data)) {
            $arr[$key] = $data[$key];
        }
    }

    return $arr;
}
