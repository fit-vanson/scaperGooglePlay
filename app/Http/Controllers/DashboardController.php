<?php

namespace App\Http\Controllers;

use App\Models\AppsInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Nelexa\GPlay\GPlayApps;

class DashboardController extends Controller
{
    public function __construct() {
        ini_set('max_execution_time',500);
    }
  // Dashboard - Analytics
  public function dashboardAnalytics(Request  $request)
  {
      if($request->category){
          $category = $request->category;
          $topApps = $this->getTopApps($category);
          return response()->json($topApps);
      }
      if($request->key){
          $key = $request->key;
          $topGrowths = $this->getTopGrowths(7,$key,5);
          return response()->json($topGrowths);
      }
      $totalAppFollow = AppsInfo::where('status', '=',1)->count();
      $pageConfigs = ['pageHeader' => false];
      $topApps = $this->getTopApps();
      $Categories = $this->getCategories();
      $topGrowths = $this->getTopGrowths(7,'installs',5);




    return view('/content/dashboard/dashboard-analytics', [
        'pageConfigs' => $pageConfigs,
        'Categories' =>$Categories,
        'topApps' =>$topApps,
        'totalAppFollow' =>$totalAppFollow,
        'topGrowths' =>$topGrowths
        ]);
  }

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
//      dd(Session::all());
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
  }
  public function analytics(Request $request){
      $key_word =$request->input_search_key;
      $records = AppsInfo::where('summary', 'like', '%' .$key_word . '%')
            ->orwhere('description', 'like', '%' .$key_word . '%')
            ->orwhere('name', 'like', '%' .$key_word . '%')
            ->get();
      $data_arr = array();
      if($records){
          foreach ($records as $record){
              $data = json_decode($record->data,true);
              $data_arr=array_merge($data_arr,$data);

          }

          $tmp = array();
          foreach( $data_arr as $entry  ) {
              $date = $entry["date"];
              if( !array_key_exists( $date, $tmp ) ) {
                  $tmp[$date] = array();
              }
              $tmp[$date]['installs'][] = $entry["installs"];
              $tmp[$date]['numberVoters'][] = $entry["numberVoters"];
              $tmp[$date]['numberReviews'][] = $entry["numberReviews"];
          }
           foreach( $tmp as $date => $item) {
              $sum_installs = array_sum($item['installs']);
              $sum_numberVoters = array_sum($item['numberVoters']);
              $sum_numberReviews = array_sum($item['numberReviews']);
              $installs [] =[
                  'x' => $date,
                  'y' => ($sum_installs / count($item['installs'])),
              ];
              $votes [] =[
                  'x' => $date,
                  'y' => ($sum_numberVoters / count($item['numberVoters'])),
              ];
              $reviews [] =[
                  'x' => $date,
                  'y' => ($sum_numberReviews / count($item['numberReviews']))
              ];
          }
          return response()->json([$installs,$votes,$reviews]);
      }
  }
  public function getCategories(){
      $gplay = new GPlayApps();
      $Categories = $gplay->getCategories();
      foreach ($Categories as $category)
      {
          $arr_category[] = [
              'id' => $category->getId(),
              'name' => $category->getName(),
          ];
      }
      return $arr_category;
  }
  public function getTopApps($category = null){
      $gplay = new GPlayApps();
      $topApps = $gplay->getTopApps($category,null,5);
      foreach ($topApps as $app){
          $arr_app[] = [
              'url' => $app->getUrl(),
              'icon' => $app->getIcon()->getUrl(),
              'name' => $app->getName(),
              'score'=> number_format($app->getScore(),1)
          ];
      }
      return $arr_app;
  }

  public function getTopGrowths($time,$key,$limit){
        $apps = AppsInfo::where('status',1)->get();
        foreach ($apps as $app){
            $data = json_decode($app->data,true);
            $tmp = array();
            foreach( $data as $entry  ) {
                $date = $entry["date"];
                if( !array_key_exists( $date, $tmp ) ) {
                    $tmp[$date] = array();
                }
                $tmp[$date] = $entry[$key];
            }
            if( array_key_exists( Carbon::now()->format('Y-m-d'), $tmp ) & array_key_exists( Carbon::now()->subDay($time)->format('Y-m-d'), $tmp ) ) {
                $currentTime = $tmp[Carbon::now()->format('Y-m-d')];
                $setTime = $tmp[Carbon::now()->subDay($time)->format('Y-m-d')];
                $result = $currentTime -$setTime;
                if($setTime > 0){
                    $percent = $result/$setTime * 100;
                }

                $arr_app[] =[
                    'appId' => $app->appId,
                    'icon' => $app->logo,
                    'name' => $app->name,
                    'result'=> $result,
                    'percent' =>$percent
                ];
            }
        }
      $keys = array_column($arr_app, 'result');
      array_multisort($keys, SORT_DESC, $arr_app);

      $arr_app = array_slice($arr_app, 0, $limit);
      return $arr_app;
  }

}
