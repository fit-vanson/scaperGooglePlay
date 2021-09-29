<?php

namespace App\Http\Controllers;

use App\Models\AppsInfo;
use App\Models\KeyWords;
use App\Models\SaveTemp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Nelexa\GPlay\GPlayApps;

class GooglePlayController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "googleplay/", 'name' => "Google Play"],
        ];
        return view('/content/googleplay/index', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
    public function package()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "googleplay/", 'name' => "Google Play"],['name' => "Package"]
        ];
        return view('/content/googleplay/package', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function filter_app_list(){
        {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"], ['link' => "googleplay/", 'name' => "Google Play"],['name' => "Package"]
            ];
            return view('/content/googleplay/filter', [
                'breadcrumbs' => $breadcrumbs
            ]);
        }
    }
    public function followAppIndex()
    {

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "googleplay/", 'name' => "Google Play"],['name' => "App đang theo dõi"]
        ];
        return view('/content/googleplay/followAppIndex', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
    public function postIndex(Request $request){
        SaveTemp::query()->truncate();
        ini_set('max_execution_time',300);
        $input_search = $request->input_search;
        $gplay = new GPlayApps();
        $appsInfo = $gplay->search($input_search,250);
        $searchSuggests = $gplay->getSearchSuggestions($input_search);
        foreach ($searchSuggests as $searchSuggest){
            KeyWords::updateOrCreate(
                [
                    'keyword' =>$searchSuggest
                ]
            );
        }
        foreach ($appsInfo as $appInfo){
            $appInfo =  $gplay->getAppInfo($appInfo->getId());
            $screenshots = $appInfo->getScreenshots();
            $url_screenshot = [];
            foreach ($screenshots as $screenshot){
                $url_screenshot[] = $screenshot->getUrl();
            }
            if($appInfo->getReleased() != null){
                $released = $appInfo->getReleased()->getTimestamp();
            }
            if($appInfo->getUpdated() != null){
                $updated = $appInfo->getUpdated()->getTimestamp();
            }
            $url_screenshot = json_encode($url_screenshot);
            SaveTemp::updateOrCreate(
                [
                    'logo' => $appInfo->getIcon()->getUrl(),
                    'appId' => $appInfo->getId(),
                    'name' => $appInfo->getName(),
                    'summary' => $appInfo->getSummary(),
                    'developer' => json_encode($appInfo->getDeveloper()),
                    'cover' => $appInfo->getCover(),
                    'screenshots' =>$url_screenshot,
                    'size' =>$appInfo->getSize(),
                    'installs' => $appInfo->getInstalls(),
                    'score' => $appInfo->getScore(),
                    'numberVoters' => $appInfo->getNumberVoters(),
                    'numberReviews' => $appInfo->getNumberReviews(),
                    'offersIAPCost' => $appInfo->isContainsIAP(),
                    'containsAds' => $appInfo->isContainsAds(),
                    'released' => $released ,
                    'updated' => $updated
                ]);

        }
        return response()->json(['success'=>'Thành công.']);
    }
    public function post_filter_app_list(Request $request){
        dd($request->all());

        $input_search = $request->input_search;
        $gplay = new GPlayApps();
        $existsApp = $gplay->existsApp($input_search);
        if($existsApp){
            $appInfo = $gplay->getAppInfo($input_search);
            $screenshots = $appInfo->getScreenshots();
            $url_screenshot = [];
            foreach ($screenshots as $screenshot){
                $url_screenshot[] = $screenshot->getUrl();
            }
            if($appInfo->getReleased() != null){
                $released = $appInfo->getReleased()->getTimestamp();
            }
            if($appInfo->getUpdated() != null){
                $updated = $appInfo->getUpdated()->getTimestamp();
            }
            $url_screenshot = json_encode($url_screenshot);
            SaveTemp::updateOrCreate(
                [
                    'logo' => $appInfo->getIcon()->getUrl(),
                    'appId' => $appInfo->getId(),
                    'name' => $appInfo->getName(),
                    'summary' => $appInfo->getSummary(),
                    'developer' => json_encode($appInfo->getDeveloper()),
                    'cover' => $appInfo->getCover(),
                    'screenshots' =>$url_screenshot,
                    'size' =>$appInfo->getSize(),
                    'installs' => $appInfo->getInstalls(),
                    'score' => $appInfo->getScore(),
                    'numberVoters' => $appInfo->getNumberVoters(),
                    'numberReviews' => $appInfo->getNumberReviews(),
                    'offersIAPCost' => $appInfo->isContainsIAP(),
                    'containsAds' => $appInfo->isContainsAds(),
                    'released' => $released ,
                    'updated' => $updated
                ]);
        }
        dd(2);
        $searchSuggests = $gplay->getSearchSuggestions($input_search);
        foreach ($searchSuggests as $searchSuggest){
            KeyWords::updateOrCreate(
                [
                    'keyword' =>$searchSuggest
                ]
            );
        }
        foreach ($appsInfo as $appInfo){
            $appInfo =  $gplay->getAppInfo($appInfo->getId());


        }
        return response()->json(['success'=>'Thành công.']);
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
        $totalRecords = SaveTemp::select('count(*) as allcount')->count();
        $totalRecordswithFilter = SaveTemp::select('count(*) as allcount')
            ->where('name', 'like', '%' .$searchValue . '%')
            ->orwhere('appId', 'like', '%' .$searchValue . '%')
            ->count();
        // Fetch records
        $records = SaveTemp::with('checkExist')->orderBy($columnName,$columnSortOrder)

            ->where('appId', 'like', '%' .$searchValue . '%')
            ->orwhere('name', 'like', '%' .$searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        foreach($records as $record){
            $note = '';
            $action = '<div class="avatar avatar-status bg-light-primary">
                                    <span class="avatar-content">                                  
                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->appId.'" class="btn-flat-primary showLink">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>  
                                        </a>
                                    </span>
                                </div>';
            if($record->checkExist != null){
                $note = $record->checkExist->note;
                if($record->checkExist->status == 1){
                     $action .= ' <div class="avatar avatar-status bg-light-warning">
                                    <span class="avatar-content">
                                    <a href="javascript:void(0)" onclick="unfollowApp(\''.$record->appId.'\')" class="btn-flat-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    </a>
                                    </span>
                                </div>';
                }else{
                    $action .= ' <div class="avatar avatar-status bg-light-secondary">
                                    <span class="avatar-content">
                                       <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->appId.'" class="btn-flat-secondary followApp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> </span>
                                    </a>
                                </div>';
                }
                $action .= ' <div class="avatar avatar-status bg-light-info">
                                 <span class="avatar-content">
                                    <a href="../googleplay/detail?id='.$record->appId.'" target="_blank" class="btn-flat-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                </span>
                             </div>';
            }

            else{
                $action .= ' <div class="avatar avatar-status bg-light-secondary">
                                    <span class="avatar-content">
                                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->appId.'" class="btn-flat-secondary followApp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> </span>
                                    </a>
                                </div>';
            }
            if($record->released != null){
                $released = date('d-m-Y',$record->released);
            }else{
                $released ='null';
            }
            if($record->updated != null){
                $updated = date('d-m-Y',$record->updated);
            }else{
                $updated ='null';
            }

            $data_arr[] = array(
                "idr" => '',
                "id" => $record->id,
                "logo" => $record->logo,
                "appId"=>$record->appId,
                "name"=>$record->name,
                "summary"=>$record->summary,
                "developer_url"=>json_decode($record->developer,true)['url'],
                "developer_name"=>json_decode($record->developer,true)['name'],
                "installs" => number_format($record->installs),
                "numberVoters" =>number_format($record->numberVoters),
                "numberReviews" => number_format($record->numberReviews),
                "score" => number_format($record->score,1),
                "action" => $action,
                "cover" =>$record->cover,
                "offersIAPCost" =>$record->offersIAPCost,
                "containsAds" =>$record->containsAds,
                "size" => $record->size,
                "released" => $released,
                "updated" => $updated,
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
    public function get_filter_app_list(Request $request){
       $draw = $request->get('draw');
       $search_arr = $request->get('search');
       $searchValue = $search_arr['value']; // Search value


       // Total records
       $totalRecords = 1;
       $totalRecordswithFilter = 1;
       // Fetch records
        $data_arr = array();
        $released = $updated = 'N/A';
        if($searchValue != null){
            $gplay = new GPlayApps();
            $existsApp = $gplay->existsApp($searchValue);
            if($existsApp) {
                $check = AppsInfo::where('appId',$searchValue)->first();

                $appInfo = $gplay->getAppInfo($searchValue);
                $screenshots = $appInfo->getScreenshots();
                $url_screenshot = [];
                foreach ($screenshots as $screenshot) {
                    $url_screenshot[] = $screenshot->getUrl();
                }
                if ($appInfo->getReleased() != null) {
                    $released = $appInfo->getReleased()->format('d-m-Y');
                }
                if ($appInfo->getUpdated() != null) {
                    $updated = $appInfo->getUpdated()->format('d-m-Y');
                }
                $note = '';
                $action = '<div class="avatar avatar-status bg-light-primary">
                                    <span class="avatar-content">
                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$appInfo->getId().'" class="btn-flat-primary showLink">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                        </a>
                                    </span>
                                </div>';
                if($check != null){
                    $note = $check->note;
                    if($check->status == 1){
                        $action .= ' <div class="avatar avatar-status bg-light-warning">
                                    <span class="avatar-content">
                                    <a href="javascript:void(0)" onclick="unfollowApp(\''.$check->appId.'\')" class="btn-flat-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    </a>
                                    </span>
                                </div>';
                    }else{
                        $action .= ' <div class="avatar avatar-status bg-light-secondary">
                                    <span class="avatar-content">
                                       <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$check->appId.'" class="btn-flat-secondary followApp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> </span>
                                    </a>
                                </div>';
                    }
                    $action .= ' <div class="avatar avatar-status bg-light-info">
                                 <span class="avatar-content">
                                    <a href="../googleplay/detail?id='.$check->appId.'" target="_blank" class="btn-flat-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                </span>
                             </div>';
                }

                else{
                    $action .= ' <div class="avatar avatar-status bg-light-secondary">
                                    <span class="avatar-content">
                                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$appInfo->getId().'" class="btn-flat-secondary followApp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> </span>
                                    </a>
                                </div>';
                }
                $data_arr[] = array(
                    'logo' => $appInfo->getIcon()->getUrl(),
                    'appId' => $appInfo->getId(),
                    'name' => $appInfo->getName(),
                    'summary' => $appInfo->getSummary(),
                    'developer' => json_encode($appInfo->getDeveloper()),
                    'cover' => $appInfo->getCover()->getUrl(),
                    'screenshots' =>$url_screenshot,
                    'size' =>$appInfo->getSize(),
                    'installs' => number_format($appInfo->getInstalls()),
                    'score' => number_format($appInfo->getScore(),1),
                    'numberVoters' => number_format($appInfo->getNumberVoters()),
                    'numberReviews' => number_format($appInfo->getNumberReviews()),
                    'offersIAPCost' => $appInfo->isContainsIAP(),
                    'containsAds' => $appInfo->isContainsAds(),
                    'released' => $released ,
                    'updated' => $updated,
                    "idr" => '',
                    "id" => $appInfo->getId(),
                    "developer_url"=>$appInfo->getDeveloper()->getUrl(),
                    "developer_name"=>$appInfo->getDeveloper()->getName(),
                    "note" => $note,
                    "action" => $action,
                );
            }
        }
       $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
       );
       echo json_encode($response);



    }
    public function getFollowAppIndex(Request $request){
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
        $totalRecords = AppsInfo::where('status', '=',1)->count();
        $totalRecordswithFilter = AppsInfo::select('count(*) as allcount')
            ->where(function ($a) use ($searchValue) {
                $a->where('name', 'like', '%' .$searchValue . '%')
                    ->orwhere('appId', 'like', '%' .$searchValue . '%');
            })
            ->where(function ($q){
                $q->where('status', '=',1);
            })
            ->count();

        $records = AppsInfo::orderBy($columnName,$columnSortOrder)
            ->where(function ($a) use ($searchValue) {
                $a->where('name', 'like', '%' .$searchValue . '%')
                    ->orwhere('appId', 'like', '%' .$searchValue . '%');
            })
            ->where(function ($q){
                $q->where('status', '=',1);
            })
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        foreach($records as $record){
            $action = '<div class="avatar avatar-status bg-light-primary">
                                    <span class="avatar-content">
                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->appId.'" class="btn-flat-primary showLink">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                        </a>
                                    </span>
                                </div>';

                    $action .= ' <div class="avatar avatar-status bg-light-warning">
                                    <span class="avatar-content">
                                    <a href="javascript:void(0)" onclick="unfollowApp(\''.$record->appId.'\')" class="btn-flat-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    </a>
                                    </span>
                                </div>';

                $action .= ' <div class="avatar avatar-status bg-light-info">
                                 <span class="avatar-content">
                                    <a href="../googleplay/detail?id='.$record->appId.'" target="_blank" class="btn-flat-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                </span>
                             </div>';

            $data = json_decode($record->data,true);
            $data_arr[] = array(
                "idr" => '',
                "id" => $record->id,
                "logo" => $record->logo,
                "appId"=>$record->appId,
                "name"=>$record->name,
                "summary"=>$record->summary,
                "installs" => number_format($data[0]['installs']),
                "numberVoters" =>number_format($data[0]['numberVoters']),
                "numberReviews" => number_format($data[0]['numberReviews']),
                "score" => number_format($data[0]['score'],1),
                "note" => $record->note,
                "action" => $action,
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
    public function cronApps(Request $request){
        ini_set('max_execution_time',500);
        $time_to_cron = Carbon::now()->today();
        $apps = AppsInfo::where('status',1)->where('updated_at','<=',$time_to_cron)->limit(100)->get();
        if(isset($apps)){
            foreach ($apps as $app){
                echo '<br/>'.'Dang chay App: ' . $app->appId;
                $data = json_decode($app->data,true);
                $dataCron =[];
                if($data[0]['date'] != Carbon::now()->format('Y-m-d')){
                    $gplay = new GPlayApps();
                    $appInfo = $gplay->existsApp($app->appId);

                    if($appInfo != false){
                        $appInfo = $gplay->getAppInfo($app->appId);
                        $dataCron [] = [
                            'date' => Carbon::now()->format('Y-m-d'),
                            'size' => $appInfo->getSize(),
                            'appVersion' => $appInfo->getAppVersion(),
                            'installs' => $appInfo->getInstalls(),
                            'score' => $appInfo->getScore(),
                            'numberVoters' => $appInfo->getNumberVoters(),
                            'numberReviews' => $appInfo->getNumberReviews(),
                            'histogramRating' => $appInfo->getHistogramRating(),
                            'updated' => $appInfo->getUpdated(),
                        ];
                    }

                }
                $dataApp = array_merge($dataCron, $data);
                $dataApp = json_encode($dataApp);
                AppsInfo::updateOrCreate(
                    [
                        'appId' => $app->appId,
                    ],
                    [
                        'data' => $dataApp,
                        'updated_at'=>time()
                    ]);

            }
        }if(count($apps)==0){
            echo '<br/>'.'Chưa đến giờ Cron';
        }
    }
    public function followApp(Request $request, $note=null){
        ini_set('max_execution_time',500);
        $gplay = new GPlayApps();
        if(is_array($request->id)){
            $appId = $request->id;
            $appsInfo = $gplay->getAppsInfo($appId);
        }else{
            $appId[] = $request->id;
            $appsInfo = $gplay->getAppsInfo($appId);
        }
        $checkExist = AppsInfo::whereIn('appId',$appId)->get();
        $checkExist = json_decode(json_encode($checkExist), True);


        $infoReview = [];
        $data =[];
        $url_screenshot = [];

        foreach ($appsInfo as $appInfo){
            $data[]  = [
                'date' => Carbon::now()->format('Y-m-d'),
                'size' => $appInfo->getSize(),
                'appVersion' => $appInfo->getAppVersion(),
                'installs' => $appInfo->getInstalls(),
                'score' => $appInfo->getScore(),
                'numberVoters' => $appInfo->getNumberVoters(),
                'numberReviews' => $appInfo->getNumberReviews(),
                'histogramRating' => $appInfo->getHistogramRating(),
                'updated' => $appInfo->getUpdated(),
            ];
            $reviews = $gplay->getReviews($appInfo->getId(),500);
            foreach ($reviews as $review){
                $infoReview[] =[
                    'id' => $review->getId(),
                    'userName' => $review->getUserName(),
                    'text' => $review->getText(),
                    'reply' => $review->getReply(),
                    'date' => $review->getDate()->getTimestamp(),
                    'score' => $review->getScore(),
                    'countLikes' => $review->getCountLikes(),
                    'avatar' => $review->getAvatar()->getUrl(),
                ];
            }
            $screenshots = $appInfo->getScreenshots();
            foreach ($screenshots as $screenshot){
                $url_screenshot[] = $screenshot->getUrl();
            }
            $check = array_search($appInfo->getId(), array_column($checkExist, 'appId'));
            if($check !== false){
                $dataCheck = json_decode($checkExist[$check]['data'],true);
                $searchDate = array_search(Carbon::now()->format('Y-m-d'),array_column($dataCheck, 'date'));
                if($searchDate == false){
                    $data = array_merge($data, $dataCheck);
                }else{
                    $data= array_merge($dataCheck);
                }
            }
            $json_data = json_encode($data);
            $json_review = json_encode($infoReview);
            $json_screenshot = json_encode($url_screenshot);
            AppsInfo::updateOrCreate(
                [
                    'appId' => $appInfo->getId(),
                ],
                [
                    'logo' => $appInfo->getIcon()->getUrl(),
                    'appId' => $appInfo->getId(),
                    'name' => $appInfo->getName(),
                    'privacyPoliceUrl' => $appInfo->getPrivacyPoliceUrl(),
                    'cover' => $appInfo->getCover()->getUrl(),
                    'screenshots' => $json_screenshot,
                    'summary' => $appInfo->getSummary(),
                    'description' => $appInfo->getDescription(),
                    'released' => $appInfo->getReleased(),
                    'data' => $json_data,
                    'note' => $note,
                    'reviews' => $json_review,
                    'offersIAPCost' => $appInfo->isContainsIAP(),
                    'containsAds' => $appInfo->isContainsAds(),
                    'status' => 1
                ]);
        }
        return response()->json(['success'=>'App đã được Follow.']);
    }
    public function unfollowApp(Request $request){
        AppsInfo::where('appId',$request->id)->update(['status'=>0]);
        return response()->json([
            'success'=>'App đã được UnFollow.',
            ]);
    }
    public function detailApp(Request $request){
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "googleplay/", 'name' => "Google Play"], ['name' => "DeltailApp"]
        ];
        $appInfo = AppsInfo::where('appId',$request->id)->first();
        $data = json_decode($appInfo->data,true);
        return view('/content/googleplay/infoApp', [
            'breadcrumbs' => $breadcrumbs,
            'appInfo'=>$appInfo,
            'data'=>$data,
        ]);
    }
    public function detailApp_Ajax(Request $request){
        $appInfo = AppsInfo::where('appId',$request->id)->first();
        $data = json_decode($appInfo->data,true);
        $keys = array_column($data, 'date');
        array_multisort($keys, SORT_DESC, $data);
        foreach ($data as $item){
            $histogramRating [] =[
                'histogramRating' => $item['histogramRating']
            ];
            $installs [] =[
                'x' => $item['date'],
                'y' => $item['installs']
            ];
            $votes [] =[
                'x' => $item['date'],
                'y' => $item['numberVoters']
            ];
            $reviews [] =[
                'x' => $item['date'],
                'y' => $item['numberReviews']
            ];
        }
        return response()->json([$histogramRating,$installs,$votes,$reviews]);

    }
    public function chooseApp(Request $request)
    {
        $appsChoose = $request->checkbox;
        return view('content.googleplay.choose',[
            'appsChoose' => $appsChoose
        ]);
    }
    public function changeNote(Request $request){
        $this->followApp($request,$request->note);
        return response()->json(['success'=>'Thành công']);
    }

}
