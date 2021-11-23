<?php

namespace App\Http\Controllers;

use App\Models\AppGallery;
use App\Models\KeyWords;
use App\Models\SaveTemp;
use Illuminate\Http\Request;
use Nelexa\GPlay\GPlayApps;

class AppGalleryController extends Controller
{
    public function package()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "appgallery/", 'name' => "App Gallery"],['name' => "Package"]
        ];
        return view('/content/appgallery/package', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function getIndex(Request $request){
        ini_set('max_execution_time',1000);
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');


        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = AppGallery::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AppGallery::select('count(*) as allcount')
            ->where('name', 'like', '%' .$searchValue . '%')
            ->orwhere('appId', 'like', '%' .$searchValue . '%')
            ->count();
        // Fetch records
        $records = AppGallery::orderBy($columnName,$columnSortOrder)

            ->where('appId', 'like', '%' .$searchValue . '%')
            ->orwhere('name', 'like', '%' .$searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        foreach($records as $record){

            $note = '';
            $download = '<div class="avatar avatar-status bg-light-primary">
                                    <span class="avatar-content">
                                        <a href="'.$record->downurl.'" data-toggle="tooltip" class="btn-flat-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                        </a>
                                    </span>
                                </div>';
            if($record->released != null){
                $released = $record->released;
            }else{
                $released ='null';
            }

            $data_arr[] = array(
                "idr" => '',
                "id" => $record->id,
                "logo" => $record->logo,
                "appId"=>$record->appId,
                "package"=>$record->package,
                "name"=>$record->name,
                "summary"=>$record->summary,
                "developer"=>$record->developer,
                "installs" => $record->installs,
                "numberVoters" => $record->numberVoters,
                "numberReviews" => $record->numberReviews,
                "score" => $record->score,
                "download" => $download,
                "offersIAPCost" =>$record->offersIAPCost,
                "containsAds" =>$record->containsAds,
                "size" => $record->size,
                "released" => $released,
//                "updated" => $updated,
                "note" => $note,
                "screenshots" =>json_decode($record->screenshots,true),
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
    }

    public function postIndex(Request $request){
        AppGallery::query()->truncate();
        ini_set('max_execution_time',300);
        $input_search = str_replace(" ","+",$request->input_search);
        $searchValue = $this->searchKey($input_search);
        foreach ($searchValue as $value){
            $appDetail = $this->detailApp($value);

            AppGallery::updateOrCreate(
                [
                    'logo' => $appDetail['icon'],
                    'appId' => $appDetail['appid'],
                    'package' => $appDetail['package'],
                    'name' => $appDetail['name'],
                    'summary' => $appDetail['body'],
                    'developer' => $appDetail['developer'],
                    'screenshots' =>json_encode($appDetail['images']),
                    'size' =>$appDetail['sizeDesc'],
                    'installs' => $appDetail['intro'],
                    'score' =>$appDetail['starDesc'],
                    'numberVoters' => $appDetail['gradeCount'],
                    'numberReviews' => $appDetail['commentCount'],
                    'offersIAPCost' =>  $appDetail['tariffDesc'] == 'Free' ? 0 : 1,
                    'containsAds' => $appDetail['labelNames'][0]['type'],
                    'released' => $appDetail['releaseDate'],
                    'downurl' => $appDetail['downurl'],
                ]);
        }
        return response()->json(['success'=>'Thành công.']);
    }

    function searchKey($key) {
//        $ch = curl_init("https://web-dra.hispace.dbankcloud.cn/uowap/index?method=internal.getTabDetail&serviceType=20&reqPageNum=1&uri=searchApp|".$key."&maxResults=30&version=10.0.0&zone=&locale=en");
        $ch = curl_init("https://web-dra.hispace.dbankcloud.cn/uowap/index?method=internal.getTabDetail&serviceType=20&reqPageNum=1&uri=searchApp%7C".$key."&maxResults=25&version=10.0.0&zone=&locale=en");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        $data = json_decode($data,true);
        foreach ($data['layoutData'] as $value) {
            $result = $value['dataList'];
            foreach ($result as $val){
                $appid[] = $val['appid'];
            }
        }
        return $appid;
    }

    public function detailApp($appId){
        $ch = curl_init("https://web-dra.hispace.dbankcloud.cn/uowap/index?method=internal.getTabDetail&uri=app|".$appId."&locale=en"); // such as http://example.com/example.xml
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        $data = json_decode($data,true);
        $dataList=[];
        foreach ($data['layoutData'] as $value) {
            $result = $value['dataList'];
            foreach ($result as $val){
                $dataList += $val;
            }
        }
       return $dataList;
    }

    public function chooseApp(Request $request)
    {
        $appsChoose = $request->checkbox;
        return view('content.appgallery.choose',[
            'appsChoose' => $appsChoose
        ]);
    }

}
