<?php
/**
 * Created by IntelliJ IDEA.
 * User: notebook
 * Date: 7. 6. 2019
 * Time: 13:20
 */

namespace Modules\Campaigns\Services;


interface WidgetResultServiceInterface
{
    public function getByWidgetId($id);

    public function update($request, $id);
}