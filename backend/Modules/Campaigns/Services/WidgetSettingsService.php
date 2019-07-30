<?php
/**
 * Created by IntelliJ IDEA.
 * User: notebook
 * Date: 7. 6. 2019
 * Time: 13:10
 */

namespace Modules\Campaigns\Services;


use Modules\Campaigns\Entities\WidgetSettings;

class WidgetSettingsService implements WidgetSettingsServiceInterface
{

    /**
     * @param $id
     * @return mixed
     */
    public function getByWidgetId($id): WidgetSettings
    {
        return WidgetSettings::where('widget_id', $id)->first();
    }
}