<?php
/**
 * Created by IntelliJ IDEA.
 * User: notebook
 * Date: 7. 6. 2019
 * Time: 13:20
 */

namespace Modules\Campaigns\Services;


use Illuminate\Http\Request;
use Modules\Campaigns\Entities\WidgetResult;

class WidgetResultService implements WidgetResultServiceInterface
{

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|WidgetResult[]
     */
    public function getByWidgetId($id)
    {
        return WidgetResult::all()
            ->where('widget_id', $id);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update( $request, $id)
    {
        $widgetResults = WidgetResult::all()
            ->where('widget_id', $id);
        foreach ($widgetResults as $result) {
            WidgetResult::find($result['id'])->update([
                'desktop' => $request['desktop'],
                'tablet' => $request['tablet'],
                'mobile' => $request['mobile']
            ]);
        }
    }
}